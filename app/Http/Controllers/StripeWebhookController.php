<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $endpointSecret = config('services.stripe.webhook.secret');
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret,
                config('services.stripe.webhook.tolerance', 300)
            );
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            /** @var \Stripe\Checkout\Session $session */
            $session = $event->data->object;

            if (($session->payment_status ?? null) !== 'paid') {
                return response('Not paid yet', 200);
            }

            DB::transaction(function () use ($session) {
                $order = Order::with('details')->lockForUpdate()
                    ->where('stripe_session_id', $session->id)
                    ->first();

                if (!$order) return;

                if ($order->payment_status !== 'paid') {
                    $order->update([
                        'status'          => 'processing',
                        'payment_status'  => 'paid',
                        'payment_intent'  => $session->payment_intent ?? null,
                    ]);

                    foreach ($order->details as $d) {
                        if ($d->product_id && $d->quantity > 0) {
                            Product::where('id', $d->product_id)
                                ->where('stock', '>=', $d->quantity)
                                ->decrement('stock', $d->quantity);
                        }
                    }

                    if (!empty($session->metadata->user_id)) {
                        Cart::where('user_id', (int)$session->metadata->user_id)->delete();
                    }

                    Log::info('Order paid & stock updated', ['order_id' => $order->id]);
                }
            });
        }

        // IMPORTANT: ردّ سريع 2xx لتجنّب إعادة الإرسال
        return response('OK', 200);
    }
}
