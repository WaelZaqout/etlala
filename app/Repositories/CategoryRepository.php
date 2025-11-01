<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    // =========================
    // 🧩 الدوال الخاصة بالإدارة
    // =========================

    public function search($keyword = null, $perPage = 10)
    {
        return Category::with('parent')
            ->when($keyword, fn($query) => $query->where('name', 'like', "%$keyword%"))
            ->latest()
            ->paginate($perPage);
    }

    public function countSlug($slug, $excludeId = null)
    {
        return Category::where('slug', 'like', "$slug%")
            ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
            ->count();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete($category)
    {
        return $category->delete();
    }

    // =========================
    // 🌐 الدوال الخاصة بالواجهة (Front)
    // =========================

    /**
     * جلب عدد محدود من الأقسام (للصفحة الرئيسية)
     */
    public function getLimitedCategories(int $limit = 10)
    {
        return Category::take($limit)->get();
    }

    /**
     * جلب كل الأقسام (للتصفية أو صفحات المنتجات)
     */
    public function getAllCategories()
    {
        return Category::all();
    }
}
