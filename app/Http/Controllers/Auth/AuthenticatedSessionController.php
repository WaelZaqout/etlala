<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول.
     */
    public function create(): View
    {
        return view('auth.login');
    }
    public function userLoginPage(): View
    {
        return view('auth.userlogin');
    }

    /**
     * تنفيذ عملية تسجيل الدخول.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('index'); // لوحة التحكم
        } elseif ($user->hasRole('user')) {
            return redirect()->route('Home'); // واجهة المتجر
        } else {
            Auth::logout();
            return redirect()->route('user.login')->withErrors(['role' => 'لا يوجد صلاحية لهذا الحساب.']);
        }
    }


    /**
     * تسجيل الخروج.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
