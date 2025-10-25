<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */



    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartCount = 0;
            $wishlistCount = 0;
            $wishlistItems = collect(); // سنخزّن فيها آخر منتجين فقط

            if (Auth::check()) {
                $user = Auth::user();

                $cartCount = Cart::where('user_id', $user->id)->count();
                $wishlistCount = $user->wishlist()->count();

                $wishlistItems = Wishlist::with('product')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(2) // فقط آخر منتجين
                    ->get();
            }

            $view->with([
                'cartCount' => $cartCount,
                'wishlistCount' => $wishlistCount,
                'wishlistItems' => $wishlistItems,
            ]);
        });
    }
}
