<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\FrontService;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function __construct(private FrontService $frontService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = $this->frontService->getHomePageData();

        return view('front.home', $data);
    }

    public function new()
    {
        $data = $this->frontService->getNewProductsPageData();

        return view('front.new', $data);
    }
    public function details($id)
    {
        $data = $this->frontService->getProductDetailsData($id);
        return view('front.details', $data);
    }
}
