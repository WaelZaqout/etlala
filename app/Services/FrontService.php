<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class FrontService
{

    public function __construct(
        private ProductRepository $productRepo,
        private CategoryRepository $categoryRepo
    ) {}
    public function getHomePageData(): array
    {
        $products = $this->productRepo->getLatestProducts(10);
        $categories = $this->categoryRepo->getLimitedCategories(10);
        $wishlistIds = optional(Auth::user())->wishlist()->pluck('product_id')->toArray() ?? [];

        return compact('products', 'categories', 'wishlistIds');
    }

    public function getNewProductsPageData(): array
    {
        $products = $this->productRepo->getAllProducts();
        $categories = $this->categoryRepo->getAllCategories();

        return compact('products', 'categories');
    }
    public function getProductDetailsData($id): array
    {
        $product = $this->productRepo->findProductById($id);
        $categories = $this->categoryRepo->getAllCategories();

        return compact('product', 'categories');
    }
}
