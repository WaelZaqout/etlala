<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();
        if ($cart->isEmpty()) return redirect()->route('cart.index')->with('error', 'السلة فارغة');

        $total = 0;
        foreach ($cart as $row) {
            $p = $row->product;
            $price = $p->sale_price ?: $p->price;
            $total += $price * $row->quantity;
        }

        return view('front.checkout', [
            'itemCount' => $cart->sum('quantity'),
            'total' => $total,
            'currencyLabel' => 'ر.س',
        ]);
    }

    // الدفع عند الاستلام
    public function checkoutCash(Request $request)
    {
        $user = $request->user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();
        if ($cart->isEmpty()) return redirect()->route('cart.index')->with('error', 'السلة فارغة');

        $order = null;

        DB::transaction(function () use ($user, $cart, &$order) {
            $total = 0;

            $order = Order::create([
                'user_id'        => $user->id,
                'total_price'    => 0,
                'status'         => 'pending',   // لسه ما تم التسليم
                'payment_method' => 'cash',
                'payment_status' => 'pending',   // الدفع عند التسليم
            ]);

            foreach ($cart as $row) {
                $price = $row->product->sale_price ?: $row->product->price;
                $line  = $price * $row->quantity;
                $total += $line;

                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $row->product_id,
                    'quantity'   => $row->quantity,
                    'price'      => $price,
                ]);
            }

            // حدّث الإجمالي
            $order->update(['total_price' => $total]);

            // احذف السلة (مش الطلب)
            Cart::where('user_id', $user->id)->delete();
        });

        // رجوع بنجاح (نجاح إنشاء الطلب بنظام الدفع كاش)
        return redirect()->route('checkout.success', ['session_id' => 'cash-' . $order->id])
            ->with('success', 'تم إنشاء الطلب بنجاح بنظام الدفع عند الاستلام.');
    }

    // الدفع الإلكتروني (Stripe)
    public function create(Request $request)
    {
        $user = $request->user();
        $cart = Cart::with('product')->where('user_id', $user->id)->get();
        if ($cart->isEmpty()) return redirect()->route('cart.index')->with('error', 'السلة فارغة');

        $currency = config('services.stripe.currency', 'usd');
        $lineItems = [];
        $subtotalCents = 0;

        $order = DB::transaction(function () use ($user, $cart, $currency, &$lineItems, &$subtotalCents) {
            // أنشئ Order مبدئي
            $order = Order::create([
                'user_id'        => $user->id,
                'total_price'    => 0,           // نحسبها أسفل
                'status'         => 'pending',
                'payment_method' => 'stripe',
                'payment_status' => 'unpaid',
            ]);

            foreach ($cart as $row) {
                $price = $row->product->sale_price ?: $row->product->price;
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $row->product_id,
                    'quantity'   => $row->quantity,
                    'price'      => $price,
                ]);

                $unit = (int) round($price * 100);
                $lineItems[] = [
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => $unit,
                        'product_data' => ['name' => $row->product->name],
                    ],
                    'quantity' => (int) $row->quantity,
                ];
                $subtotalCents += $unit * (int)$row->quantity;
            }

            $order->update(['total_price' => $subtotalCents / 100]);

            return $order;
        });

        // أنشئ جلسة Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('checkout.cancel',  [], true),
            'metadata'    => [
                'order_id' => (string)$order->id,
                'user_id'  => (string)$user->id,
            ],
            'customer_email' => $user->email,
        ]);

        // خزّن session id للربط بعد الرجوع
        $order->update(['stripe_session_id' => $session->id]);

        // ملاحظة: نحذف السلة بعد الدفع الناجح (في الويبهوك)، وليس الآن
        return redirect($session->url);
    }

    // صفحة النجاح (تخدم الكاش والسترايب معًا)
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $order = null;

        if ($sessionId && str_starts_with($sessionId, 'cash-')) {
            // رجوع من دفع كاش (من الدالة checkoutCash)
            $orderId = (int) str_replace('cash-', '', $sessionId);
            $order = Order::find($orderId);
        } else if ($sessionId) {
            // رجوع من Stripe
            $order = Order::where('stripe_session_id', $sessionId)->first();
        }

        return view('front.checkout-success', [
            'order' => $order,
            'currencyLabel' => 'ر.س',
        ]);
    }

    public function cancel()
    {
        return view('front.checkout-cancel');
    }
}
