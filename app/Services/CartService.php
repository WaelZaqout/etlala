<?php

namespace App\Services;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function __construct(private CartRepository $repo) {}

    public function getCartItems()
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function getCartData()
    {
        $cartItems = $this->getCartItems();

        $subtotal = $cartItems->sum(
            fn($item) =>
            $item->product->price * $item->quantity
        );

        return [
            'cartItems' => $cartItems,
            'itemCount' => $cartItems->sum('quantity'),
            'subtotal' => $subtotal,
            'total' => $subtotal, // بدون ضريبة حسب طلبك
        ];
    }

    public function addToCart($productId, $quantity = 1)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
            return $cartItem;
        }

        return Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }

    public function updateQuantity($id, $quantity)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->findOrFail($id);

        $cart->update(['quantity' => $quantity]);

        return $cart;
    }

    public function removeItem($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->findOrFail($id);

        $cart->delete();
    }
}
