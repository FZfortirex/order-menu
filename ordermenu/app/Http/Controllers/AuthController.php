<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
<<<<<<< HEAD
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
{
    $username = $request->input('username');
    $password = $request->input('password');

    if (!empty($username) && !empty($password)) {
        session()->put('logged_in', true);
        session()->put('username', $username);
        session()->save();

        // Debug session sebelum redirect
        return response()->json(session()->all());
    }

    return back()->withErrors(['login' => 'Username atau password tidak boleh kosong']);
}




    public function logout()
    {
        session()->forget('logged_in'); // Hapus session
        return redirect()->route('login');
=======
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
>>>>>>> Feat/Ordermenu-DB
    }
}
