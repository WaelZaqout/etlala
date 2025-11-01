<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service) {}

    public function index(Request $request)
    {
        $q = $request->get('q');
        $categories = $this->service->paginate($q);

        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.categories._rows', compact('categories'))->render(),
                'pagination' => view('admin.categories._pagination', compact('categories'))->render(),
            ]);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->service->createCategory($request->validated());

        return back()->with('toast', ['type' => 'success', 'message' => '✅ تمت إضافة القسم بنجاح']);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->service->updateCategory($category, $request->validated());

        return back()->with('toast', [
            'type' => 'success',
            'message' => '✅ تم التعديل بنجاح'
        ]);
    }

    public function destroy(Category $category)
    {
        $this->service->deleteCategory($category);

        return back()->with('toast', [
            'type' => 'success',
            'message' => '🗑️ تم الحذف بنجاح'
        ]);
    }
}
