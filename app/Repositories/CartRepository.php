<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    public function getUserCart($userId)
    {
        return Cart::with('product')->where('user_id', $userId)->get();
    }

    public function findItem($userId, $productId)
    {
        return Cart::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->first();
    }

    public function findById($id)
    {
        return Cart::findOrFail($id);
    }

    public function create($data)
    {
        return Cart::create($data);
    }

    public function update($cart, $quantity)
    {
        $cart->quantity = $quantity;
        return tap($cart)->save();
    }

    public function delete($cart)
    {
        return $cart->delete();
    }
}
