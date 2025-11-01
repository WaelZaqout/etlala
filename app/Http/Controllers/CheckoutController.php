<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(private CheckoutService $checkoutService) {}

    /**
     * صفحة عرض معلومات الدفع قبل الإتمام
     */
    public function checkout(Request $request)
    {
        $user = $request->user();
        $cart = $this->checkoutService->getUserCart($user);

        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        $total = $cart->sum(fn($row) => ($row->product->sale_price ?: $row->product->price) * $row->quantity);

        return view('front.checkout', [
            'itemCount' => $cart->sum('quantity'),
            'total' => $total,
            'currencyLabel' => 'ر.س',
        ]);
    }

    /**
     * الدفع عند الاستلام
     */
    public function checkoutCash(Request $request)
    {
        $order = $this->checkoutService->processCashCheckout($request->user());

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        return redirect()->route('checkout.success', ['session_id' => 'cash-' . $order->id])
            ->with('success', 'تم إنشاء الطلب بنجاح بنظام الدفع عند الاستلام.');
    }

    /**
     * الدفع الإلكتروني (Stripe)
     */
    public function create(Request $request)
    {
        $session = $this->checkoutService->processStripeCheckout($request->user());

        if (!$session) {
            return redirect()->route('cart.index')->with('error', 'السلة فارغة');
        }

        return redirect($session->url);
    }

    /**
     * صفحة نجاح الدفع
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $order = null;

        if ($sessionId && str_starts_with($sessionId, 'cash-')) {
            $orderId = (int) str_replace('cash-', '', $sessionId);
            $order = Order::find($orderId);
        } elseif ($sessionId) {
            $order = Order::where('stripe_session_id', $sessionId)->first();
        }

        return view('front.checkout-success', [
            'order' => $order,
            'currencyLabel' => 'ر.س',
        ]);
    }

    /**
     * صفحة إلغاء الدفع
     */
    public function cancel()
    {
        return view('front.checkout-cancel');
    }
}
