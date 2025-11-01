<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(private CartService $service) {}

    public function index()
    {
        $data = $this->service->getCartData();

        return view('front.cart', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $this->service->addToCart(
            $request->product_id,
            $request->quantity ?? 1
        );

        return redirect()->route('cart.index')
            ->with('success', '✅ تمت إضافة المنتج للسلة');
    }

    public function update(Request $request, $id)
    {
        $cart = $this->service->updateQuantity($id, $request->quantity);

        $data = $this->service->getCartData();

        return response()->json([
            'quantity' => $cart->quantity,
            'itemTotal' => $cart->product->price * $cart->quantity,
            'subtotal' => $data['subtotal'],
            'total' => $data['total'],
        ]);
    }

    public function destroy($id)
    {
        $this->service->removeItem($id);

        $data = $this->service->getCartData();

        return response()->json([
            'subtotal' => $data['subtotal'],
            'total' => $data['total'],
        ]);
    }
}
