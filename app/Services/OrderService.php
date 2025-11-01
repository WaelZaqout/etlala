<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private OrderRepository $repo) {}

    public function paginate($keyword = null, $status = null)
    {
        return $this->repo->search($keyword, $status);
    }

    public function createOrderFromCart()
    {
        $userId = Auth::id();

        DB::transaction(function () use ($userId, &$order) {

            // جلب السلة
            $cart = $this->repo->getCartItems($userId);
            if ($cart->isEmpty()) {
                abort(400, 'السلة فارغة');
            }
            // إنشاء الطلب
            $order = $this->repo->createOrder($userId);
            // تفاصيل الطلب
            $this->repo->attachOrderDetails($order, $cart);

            // حذف السلة
            $this->repo->deleteCart($userId);
        });

        return $order;
    }

    public function updateStatus($id, $status)
    {
        return $this->repo->updateStatus($id, $status);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }
}
