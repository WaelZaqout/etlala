<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request)
    {
        $q = $request->get('q');
        $products = $this->productService->getProducts($q);
        $categories = Category::all(); // سيتم نقلها لاحقاً ل Repository

        if (request()->ajax()) {
            $products = Product::paginate(10);
            $rows = view('admin.products._rows', compact('products'))->render();
            $pagination = view('admin.products._pagination', compact('products'))->render();

            return response()->json([
                'rows' => $rows,
                'pagination' => $pagination,
            ]);
        }

        return view('admin.products.index', compact('products', 'q', 'categories'));
    }


    public function store(StoreProductRequest $request)
    {
        $this->productService->createProduct($request->validated());

        return redirect()
            ->route('products.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تمت إضافة المنتج بنجاح'
            ]);
    }

    public function show(Product $product)
    {
        $product->load('images', 'category');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(5)
            ->get();

        return view('front.details', compact('product', 'relatedProducts'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product, $request->validated());

        return redirect()
            ->route('products.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم تعديل المنتج بنجاح'
            ]);
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);

        return redirect()
            ->route('products.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف المنتج بنجاح'
            ]);
    }
}
