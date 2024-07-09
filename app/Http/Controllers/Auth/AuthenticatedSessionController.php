<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Providers\RouteServiceProvider;
use App\Providers\AdminRouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if(Auth::user()) {
            return redirect() -> route('client.dashboard');
        }
        else {
            return view('auth.login');
        }
    }

    public function admin_auth () {
        if(Auth::guard('admin')->user()){
            return redirect() -> route('admin.dashboard');
        }
        else {
            return view('auth.admin-login');
        }
    }

    public function client_login (){
        if(Auth::user()) {
            return redirect() -> route('client.dashboard');
        }
        else {
            return view('auth.client-login');
        }
    }

    public function client_signup (){
        if(Auth::user()) {
            return redirect() -> route('client.dashboard');
        }
        else {
            return view('auth.client-signup');
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function auth(AdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(AdminRouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $cart = session('cart');
        Session::flush();
        session(['cart' => $cart]);

        Auth::guard('web')->logout();

        $request->session()->regenerate();

        return redirect('/');
    }

    public function destroyAdminSession(Request $request): RedirectResponse
    {
 
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerate();

        return redirect('/');
    }
}
