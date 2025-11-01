<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $service) {}
    public function index()
    {
        $data = $this->service->getUserProfileData(Auth::user());
        return view('front.profile.profile', $data);
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function update(Request $request)
    {
        $this->service->updateUserProfile(Auth::user(), $request->only('name', 'email', 'phone'));
        return redirect()->back()->with('success', 'تم تحديث معلوماتك بنجاح ✅');
    }
    public function myOrders()
    {

        $data = $this->service->getUserProfileData(Auth::user());


        return view('front.profile.orderuser', $data);
    }
    public function settings()
    {
        $data  = $this->service->getUserProfileData(Auth::user());

        return view('front.profile.settings', $data);
    }
    public function settingUpdate(Request $request)
    {
        $this->service->updateUserSettings(Auth::user(), $request->only('name', 'email', 'phone', 'password'));
        return back()->with('success', 'تم تحديث معلوماتك بنجاح ✅');
    }

    // صفحة المفضلة
    public function wishlist()
    {
        $wishlists = $this->service->getWishlistProducts(Auth::user());
        return view('front.profile.wishlist', compact('wishlists'));
    }

    // إضافة إلى المفضلة
    public function toggleWishlist(Request $request)
    {
        $added = $this->service->toggleWishlist(Auth::user(), $request->input('product_id'));
        return response()->json([
            'status' => $added ? 'added' : 'removed',
            'message' => $added ? '❤️ تمت الإضافة إلى المفضلة' : '💔 تمت الإزالة من المفضلة',
        ]);
    }
}
