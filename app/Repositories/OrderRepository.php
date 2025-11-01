<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Cart;

class OrderRepository
{
    public function search($keyword = null, $status = null, $perPage = 10)
    {
        return Order::with('user')
            ->when(
                $keyword,
                fn($q) =>
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$keyword%"))
            )
            ->when($status, fn($q) => $q->where('status', $status))
            ->paginate($perPage);
    }

    public function getCartItems($userId)
    {
        return Cart::with('product')->where('user_id', $userId)->get();
    }

    public function createOrder($userId)
    {
        return Order::create([
            'user_id' => $userId,
            'status' => 'pending',
            'total_price' => 0
        ]);
    }

    public function attachOrderDetails(Order $order, $cart)
    {
        $total = 0;

        foreach ($cart as $item) {
            $price = $item->product->price;
            $total += $price * $item->quantity;

            $order->details()->create([
                'product_id' => $item->product_id,
                'price' => $price,
                'quantity' => $item->quantity
            ]);
        }

        $order->update(['total_price' => $total]);

        return $order;
    }

    public function deleteCart($userId)
    {
        Cart::where('user_id', $userId)->delete();
    }

    public function find($id)
    {
        return Order::with('details.product', 'user')->findOrFail($id);
    }

    public function updateStatus($id, $status)
    {
        $order = Order::findOrFail($id);
        return $order->update(['status' => $status]);
    }

    public function delete($id)
    {
        return Order::findOrFail($id)->delete();
    }
}
