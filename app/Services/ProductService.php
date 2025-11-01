<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function __construct(private ProductRepository $productRepository) {}

    public function createProduct(array $data)
    {
        // معالجة الصورة
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'products');
        }

        // إنشاء slug فريد
        $data['slug'] = $this->generateSlug($data['name']);

        // إنشاء المنتج
        $product = $this->productRepository->create($data);



        // رفع صور المعرض
        if (isset($data['gallery'])) {
            $this->uploadGallery($product, $data['gallery']);
        }

        return $product;
    }

    public function updateProduct(Product $product, array $data)
    {
        // تحديث الصورة الرئيسية
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'products');
        }

        // تحديث slug فقط لو تغيّر الاسم
        if (isset($data['name'])) {
            $data['slug'] = $this->generateSlug($data['name'], $product->id);
        }

        // تحديث المنتج
        $this->productRepository->update($product, $data);

        // صور المعرض الجديدة
        if (isset($data['gallery'])) {
            $this->uploadGallery($product, $data['gallery']);
        }

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        // حذف الصور من التخزين
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $product->delete();
    }

    // ---------- Helper Methods ----------

    private function uploadImage($file, $path)
    {
        return $file->store($path, 'public');
    }

    private function uploadGallery(Product $product, $gallery)
    {
        foreach ($gallery as $img) {
            $path = $img->store('products/gallery', 'public');
            $product->images()->create(['image' => $path]);
        }
    }

    private function generateSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $query = Product::where('slug', 'like', $slug . '%');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $count = $query->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }
    public function getProducts(?string $keyword = null)
    {
        return $this->productRepository->search($keyword);
    }
}
