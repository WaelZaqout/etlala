<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct(private OrderService $service) {}

    public function index(Request $request)
    {
        $q = $request->get('q');
        $status = $request->get('status');

        $orders = $this->service->paginate($q, $status);

        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.orders._rows', compact('orders'))->render(),
                'pagination' => view('admin.orders._pagination', compact('orders'))->render(),
            ]);
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function store()
    {
        $this->service->createOrderFromCart();

        return redirect()->route('orders.index')->with('toast', [
            'type' => 'success',
            'message' => '✅ تم إنشاء الطلب بنجاح'
        ]);
    }

    public function show($id)
    {
        $order = $this->service->find($id);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $this->service->updateStatus($id, $request->status);

        return back()->with('toast', [
            'type' => 'success',
            'message' => '✅ تم تحديث حالة الطلب'
        ]);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return back()->with('toast', [
            'type' => 'success',
            'message' => '🗑️ تم حذف الطلب بنجاح'
        ]);
    }
}
