<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| 🛍️ واجهة المستخدم (المتجر)
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontController::class, 'index'])->name('Home');
Route::get('/new', [FrontController::class, 'new'])->name('new');
Route::get('/details', [FrontController::class, 'details'])->name('details');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| 🛒 السلة وعمليات الشراء (لليوزر المسجل فقط)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/my-orders', [ProfileController::class, 'myOrders'])->name('my.orders');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings/update', [ProfileController::class, 'settingUpdate'])->name('settings.update');

    Route::get('/profile/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
    Route::post('/wishlist/toggle', [ProfileController::class, 'toggleWishlist'])->name('wishlist.toggle');


    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/create', [CheckoutController::class, 'create'])
        ->name('checkout.create');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel',  [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout-cash', [CheckoutController::class, 'checkoutCash'])->name('cart.checkout.cash');
});

/*
|--------------------------------------------------------------------------
| 🔑 تسجيل الدخول الخاص بالـ User (واجهة المتجر)
|--------------------------------------------------------------------------
*/
// 🔑 تسجيل الدخول الخاص بالمستخدم (واجهة المتجر)
Route::get('/user/login', [AuthenticatedSessionController::class, 'userLoginPage'])->name('user.login');
Route::post('/user/login', [AuthenticatedSessionController::class, 'store'])->name('user.login.post');

/*
|--------------------------------------------------------------------------
| ⚙️ لوحة تحكم الأدمن
|--------------------------------------------------------------------------
*/

// 🔁 استدعاء ملف المصادقة الأساسي
require __DIR__ . '/auth.php';
