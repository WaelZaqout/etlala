<?php

namespace App\Services;

use Stripe\Stripe;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as StripeSession;

class CheckoutService
{
    /**
     * دالة مساعدة لجلب سلة المستخدم
     */
    public function getUserCart(User $user)
    {
        return Cart::with('product')->where('user_id', $user->id)->get();
    }

    /**
     * دالة مشتركة لإنشاء الطلب وتفاصيله
     */
    private function createOrder(User $user, string $method, string $paymentStatus)
    {
        $cart = $this->getUserCart($user);

        if ($cart->isEmpty()) {
            return null;
        }

        $order = null;

        DB::transaction(function () use ($user, $cart, $method, $paymentStatus, &$order) {
            $total = 0;

            $order = Order::create([
                'user_id'        => $user->id,
                'total_price'    => 0,
                'status'         => 'pending',
                'payment_method' => $method,
                'payment_status' => $paymentStatus,
            ]);

            foreach ($cart as $row) {
                $price = $row->product->sale_price ?: $row->product->price;
                $total += $price * $row->quantity;

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $row->product_id,
                    'quantity'   => $row->quantity,
                    'price'      => $price,
                ]);
            }

            $order->update(['total_price' => $total]);
        });

        return $order;
    }

    /**
     * الدفع عند الاستلام
     */
    public function processCashCheckout(User $user)
    {
        $order = $this->createOrder($user, 'cash', 'pending');

        if (!$order) return null;

        Cart::where('user_id', $user->id)->delete();

        return $order;
    }

    /**
     * الدفع الإلكتروني (Stripe)
     */
    public function processStripeCheckout(User $user)
    {
        $cart = $this->getUserCart($user);

        if ($cart->isEmpty()) {
            return null;
        }

        $order = $this->createOrder($user, 'stripe', 'unpaid');
        if (!$order) return null;

        $currency = config('services.stripe.currency', 'usd');
        $lineItems = [];

        foreach ($cart as $row) {
            $price = $row->product->sale_price ?: $row->product->price;
            $unit = (int) round($price * 100);

            $lineItems[] = [
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => $unit,
                    'product_data' => ['name' => $row->product->name],
                ],
                'quantity' => (int) $row->quantity,
            ];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('checkout.cancel', [], true),
            'metadata'    => [
                'order_id' => (string)$order->id,
                'user_id'  => (string)$user->id,
            ],
            'customer_email' => $user->email,
        ]);

        $order->update(['stripe_session_id' => $session->id]);

        return $session;
    }
}
