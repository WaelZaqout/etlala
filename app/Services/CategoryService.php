<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function __construct(private CategoryRepository $repo) {}

    public function paginate($keyword = null)
    {
        return $this->repo->search($keyword);
    }

    public function createCategory(array $data)
    {
        if (!empty($data['image'])) {
            $data['image'] = $data['image']->store('categories', 'public');
        }

        $data['slug'] = $this->uniqueSlug($data['name']);

        return $this->repo->create($data);
    }

    public function updateCategory($category, array $data)
    {
        if (!empty($data['image'])) {
            $this->deleteImage($category);
            $data['image'] = $data['image']->store('categories', 'public');
        }

        if (isset($data['name'])) {
            $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        }

        return $this->repo->update($category, $data);
    }

    public function deleteCategory($category)
    {
        $this->deleteImage($category);
        return $this->repo->delete($category);
    }


    private function deleteImage($category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }
    }

    private function uniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $count = $this->repo->countSlug($slug, $excludeId);

        return $count ? "$slug-$count" : $slug;
    }
}
