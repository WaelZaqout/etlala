<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**ش
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        $ordersQuery = Order::with('user')->latest();

        if ($q) {
            $ordersQuery->whereHas('user', function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            });
        }

        $orders = $ordersQuery->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.orders._rows', compact('orders'))->render(),
                'pagination' => $orders->links()->toHtml(),
            ]);
        }

        return view('admin.orders.index', compact('orders', 'q'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }



    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // 1. جلب السلة من جدول carts للمستخدم الحالي
        $cartItems = \App\Models\Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('toast', [
                'type' => 'error',
                'message' => 'السلة فارغة'
            ]);
        }

        // 2. حساب الإجمالي
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // 3. إنشاء الطلب
        $order = Order::create([
            'user_id'     => Auth::id(),
            'total_price' => $total,
            'status'      => 'pending',
        ]);

        // 4. إنشاء تفاصيل الطلب (order_items)
        // foreach ($cartItems as $item) {
        //     \App\Models\OrderItem::create([
        //         'order_id'   => $order->id,
        //         'product_id' => $item->product_id,
        //         'quantity'   => $item->quantity,
        //         'price'      => $item->product->price,
        //     ]);
        // }

        // 5. حذف السلة بعد الطلب
        \App\Models\Cart::where('user_id', Auth::id())->delete();

        // 6. إعادة توجيه
        return redirect()->route('orders.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم إرسال طلبك بنجاح'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('user', 'details.product'); // ← تفاصيل الطلب مع المنتجات

        return view('admin.orders.show', compact('order'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('admin.orders.index', compact('order'));
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,shipped,delivered,canceled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->route('orders.index')->with('toast', [
            'type' => 'success',
            'message' => 'تم تحديث حالة الطلب بنجاح'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف المنتج بنجاح'
            ]);
    }
}
