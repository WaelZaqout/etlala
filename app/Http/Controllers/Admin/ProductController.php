<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $categoriesQuery = Product::with('category')->latest();

        if ($q) {
            $categoriesQuery->where('name', 'like', '%' . $q . '%');
        }

        $products = $categoriesQuery->paginate(10);
        $categories = Category::all();
        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.products._rows', compact('products'))->render(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }

        return view('admin.products.index', compact('products', 'q', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // رفع الصورة الأساسية
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // توليد slug
        $slug = Str::slug($data['name']);
        $count = Product::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;

        // إنشاء المنتج
        $product = Product::create($data);

        // رفع صور المعرض
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $img->store('products/gallery', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تمت إضافة المنتج بنجاح'
            ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // تحميل الصور المرتبطة
        $product->load('images', 'category');

        // منتجات مشابهة (من نفس القسم، أو عشوائية لو ما فيه قسم)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(5)
            ->get();
        // $moreFromBrand = Product::where('brand', $product->brand)
        //     ->where('id', '!=', $product->id)
        //     ->take(10) // عدد المنتجات
        //     ->get();

        return view('front.details', compact('product', 'relatedProducts'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.index', compact('product'));
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // رفع الصورة الأساسية
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // توليد slug جديد
        $slug = Str::slug($data['name']);
        $count = Product::where('slug', 'like', $slug . '%')
            ->where('id', '!=', $product->id)
            ->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;

        // تحديث المنتج
        $product->update($data);

        // رفع صور المعرض الجديدة
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $path = $img->store('products/gallery', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم تعديل المنتج بنجاح'
            ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف المنتج بنجاح'
            ]);
    }
}
