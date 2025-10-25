<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $categoriesQuery = Category::with('parent')->latest();

        if ($q) {
            $categoriesQuery->where('name', 'like', '%' . $q . '%');
        }

        $categories = $categoriesQuery->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.categories._rows', compact('categories'))->render(),
                'pagination' => $categories->links()->toHtml(),
            ]);
        }

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        // رفع الصورة (إن وُجدت)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        // توليد slug تلقائيًا من الاسم
        $slug = Str::slug($data['name']);
        $count = Category::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;

        // إنشاء القسم
        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تمت إضافة القسم بنجاح'
            ]);
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
    public function edit(Category $category)
    {
        return view('admin.categories.index', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        // رفع الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        // توليد slug جديد (لكن اختياري، لو حابب تخليه يتولد بس عند الإضافة)
        $slug = Str::slug($data['name']);
        $count = Category::where('slug', 'like', $slug . '%')
            ->where('id', '!=', $category->id)
            ->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;

        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم تعديل القسم بنجاح'
            ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف القسم بنجاح'
            ]);
    }
}
