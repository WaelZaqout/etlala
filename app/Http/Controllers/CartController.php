<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

        // عدد المنتجات = مجموع الكميات
        $itemCount = $cartItems->sum('quantity');

        // الإجمالي الفرعي
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // المجموع النهائي (هنا ما عندك ضريبة حسب طلبك)
        $total = $subtotal;

        return view('front.cart', compact('cartItems', 'itemCount', 'subtotal', 'total'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $request->input('quantity', 1); // لو ما انرسل، افتراضي = 1

        // تحقق إذا المنتج موجود أصلاً بالسلة لنفس اليوزر
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // لو موجود، نزيد الكمية
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // لو مش موجود، نضيفه جديد
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'تمت إضافة المنتج للسلة');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        // إعادة حساب الإجماليات
        $subtotal = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get()
            ->sum(fn($item) => $item->product->price * $item->quantity);

        $vat = $subtotal * 0.15; // 15% ضريبة مثلًا
        $total = $subtotal + $vat;

        return response()->json([
            'quantity' => $cart->quantity,
            'itemTotal' => $cart->product->price * $cart->quantity,
            'subtotal' => $subtotal,
            'vat' => $vat,
            'total' => $total,
        ]);
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        $subtotal = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get()
            ->sum(fn($item) => $item->product->price * $item->quantity);

        $vat = $subtotal * 0.15;
        $total = $subtotal + $vat;

        return response()->json([
            'subtotal' => $subtotal,
            'vat' => $vat,
            'total' => $total,
        ]);
    }
}







