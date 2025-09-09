<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KepsekLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.kepsek-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('kepsek')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/kepsek/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('kepsek')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/kepsek/login');
    }
}
