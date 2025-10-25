<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // منتجات محدودة للعرض في الصفحة الرئيسية
        $products = Product::latest()->take(10)->get();
        $wishlistIds = Auth::check() ? Auth::user()->wishlist()->pluck('product_id')->toArray() : [];

        // جلب أول 3 أقسام فقط
        $categories = Category::take(10)->get();

        return view('front.home', compact('products', 'categories', 'wishlistIds'));
    }

    public function new()
    {
        $products = Product::latest()->get();
        $categories = Category::all(); // جلب الفئات

        return view('front.new', compact('products', 'categories'));
    }
    public function details()
    {
        $product = Product::all();
        $categories = Category::all(); // جلب الفئات

        return view('front.details', compact('product', 'categories'));
    }
}
