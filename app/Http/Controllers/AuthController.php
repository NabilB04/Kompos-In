<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Coba sebagai admin
        if (Auth::guard('admin')->attempt($credentials)) {
            session(['role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        // Coba sebagai pelanggan
        if (Auth::guard('pelanggan')->attempt($credentials)) {
            session(['role' => 'pelanggan']);
            return redirect()->route('pelanggan.landing');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

       public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('pelanggan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
