<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginAdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_admin');
    }

    public function login(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Tentukan username dan password manual
        $validUsername = 'user1';
        $validPassword = '123456';

        // Cek jika input username dan password sesuai dengan yang valid
        if ($request->username === $validUsername && $request->password === $validPassword) {
            // Simpan status login ke session
            Session::put('admin_logged_in', true);
            return redirect()->route('dashboard'); // Redirect ke dashboard
        }

        // Jika username atau password salah
        return back()->withErrors(['msg' => 'Username atau Password salah!']);
    }

    public function logout()
    {
        // Hapus session login saat logout
        Session::forget('admin_logged_in');
        return redirect()->route('login'); // Kembali ke halaman login
    }
}
