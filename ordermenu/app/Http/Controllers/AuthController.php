<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
    }
}
