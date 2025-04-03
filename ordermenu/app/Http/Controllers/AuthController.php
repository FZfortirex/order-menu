<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = \App\Models\User::where('name', $credentials['username'])->first();

        // Periksa apakah password dalam database sama dengan input (tanpa hash)
        if ($user && $credentials['password'] === $user->password) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/welcome');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/loginAccount');
    }
}
