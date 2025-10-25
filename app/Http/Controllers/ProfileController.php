<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * عرض صفحة البروفايل
     */
    public function index()
    {

        $u = Auth::user(); // المستخدم الحالي
        // جلب الطلبات الخاصة بالمستخدم
        $orders = $u->orders()
            ->with('details.product') // لجلب تفاصيل المنتجات مع الطلبات
            ->latest()
            ->get();

        return view('front.profile.profile', compact('u', 'orders'));
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->back()->with('success', 'تم تحديث معلوماتك بنجاح ✅');
    }
    public function myOrders()
    {
        $u = Auth::user();

        // جلب الطلبات الخاصة بالمستخدم مع تفاصيل المنتجات
        $orders = $u->orders()
            ->with('details.product')
            ->latest()
            ->get();

        return view('front.profile.orderuser', compact('orders', 'u'));
    }
    public function settings()
    {
        $u = Auth::user();

        // جلب الطلبات الخاصة بالمستخدم مع تفاصيل المنتجات
        $orders = $u->orders()
            ->with('details.product')
            ->latest()
            ->get();

        return view('front.profile.settings', compact('orders', 'u'));
    }
    public function settingUpdate(Request $request)
    {
        $user = Auth::user();

        // التحقق المرن (لا نجبر المستخدم على إدخال كل شيء)
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|confirmed|min:6',
        ]);

        // فلترة القيم الفارغة
        $data = array_filter($validated, fn($value) => !is_null($value) && $value !== '');

        // تحديث كلمة المرور فقط لو تم إدخالها
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // معالجة الصورة الجديدة إن وُجدت
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // تنفيذ التحديث
        $user->update($data);

        return back()->with('success', 'تم تحديث معلوماتك بنجاح ✅');
    }

    // صفحة المفضلة
    public function wishlist()
    {
        $u = Auth::user();
        $wishlists = Wishlist::with('product')
            ->where('user_id', $u->id)
            ->latest()
            ->get();

        return view('front.profile.wishlist', compact('u', 'wishlists'));
    }

    // إضافة إلى المفضلة
    public function toggleWishlist(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'يجب تسجيل الدخول أولاً 😅']);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'المنتج غير موجود 😢']);
        }

        // تحقق إن كان المنتج موجودًا بالمفضلة
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => '💔 تمت إزالة المنتج من المفضلة']);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            return response()->json(['status' => 'added', 'message' => '❤️ تمت إضافة المنتج إلى المفضلة']);
        }
    }
}
