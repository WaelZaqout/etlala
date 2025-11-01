<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    // =========================
    // 🧩 الدوال الخاصة بالإدارة
    // =========================

    public function search(?string $keyword = null, $perPage = 10)
    {
        return Product::with('category')
            ->when($keyword, fn($query) => $query->where('name', 'like', "%{$keyword}%"))
            ->latest()
            ->paginate($perPage);
    }

    public function all()
    {
        return Product::with('category')->paginate(10);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }

    // =========================
    // 🌐 الدوال الخاصة بالواجهة (Front)
    // =========================

    /**
     * جلب أحدث المنتجات بعدد محدد
     */
    public function getLatestProducts(int $limit = 10)
    {
        return Product::with('category')->latest()->take($limit)->get();
    }

    /**
     * جلب جميع المنتجات (بدون paginate)
     */
    public function getAllProducts()
    {
        return Product::with('category')->latest()->get();
    }

    /**
     * جلب المنتجات حسب القسم
     */
    public function getProductsByCategory(int $categoryId)
    {
        return Product::with('category')
            ->where('category_id', $categoryId)
            ->latest()
            ->get();
    }
    public function findProductById($id)
    {
        return Product::with('category')->findOrFail($id);
    }
}
