<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FrontAuthenticatedSessionController extends Controller
{
    /**
     * Display the user login view.
     */
    public function create(): View
    {
        return view('front.auth.login');
    }

    /**
     * Handle an incoming authentication request for users.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Assuming users without admin role are regular users
        if ($user->hasRole('admin')) {
            // If somehow an admin logs in here, redirect to admin
            return redirect()->route('index');
        } else {
            // Redirect regular users to home or profile
            return redirect()->route('Home');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
