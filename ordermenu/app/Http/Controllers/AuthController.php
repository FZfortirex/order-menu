<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function index()
    {

    }

    public function showQr($meja)
    {
        return view('auth.login-table', compact('meja'));
    }

    public function loginByQr(Request $request)
    {
        $nomorMeja = $request->query('meja');

        if (!$nomorMeja) {
            return redirect()->route('home')->with('error', 'QR tidak valid.');
        }

        $user = User::where('name', $nomorMeja)->where('role', 'customer')->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Meja tidak tersedia.');
        }

        $newSessionId = Str::uuid()->toString();

        $user->current_session_id = $newSessionId;
        $user->session_expired_at = Carbon::now()->addMinutes(30);
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session(['meja' => $nomorMeja, 'current_session_id' => $newSessionId]);

        Auth::login($user);

        return redirect()->route('order.menu');
    }
    
    public function showLogin(Request $request)
    {
        // Deteksi apakah mobile atau desktop
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        return view($isMobile ? 'auth.login-mobile' : 'auth.login-desktop');
    }

    // Login Pakai Database
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $credentials['username'])->first();

        if ($user && $credentials['password'] === $user->password) {
            auth()->loginUsingId($user->id); 
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                $orders = Order::all();
                Session::put('admin_logged_in', true);
                return redirect()->route('dashboard');
            } else {
                return redirect()->intended('/menu');
            }
        } else if ($user && Hash::check($credentials['password'], $user->password)) {
            auth()->loginUsingId($user->id); 
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                $orders = Order::all();
                Session::put('admin_logged_in', true);
                return redirect()->route('dashboard');
            } else {
                return redirect()->intended('/menu');
            }
        }

        // Tambahan dari versimu: Debug session jika gagal login
        session()->put('login_attempt', [
            'username' => $credentials['username'],
            'status' => 'failed',
            'timestamp' => now(),
        ]);

        // Balikin error
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Logout Pakai Database
    public function logout(Request $request)
    {
        // Auth::logout(); // Hapus session
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // Session::forget('admin_logged_in');

        // Tambahan dari versimu: Hapus session manual
        return redirect('/loginAccount');
    }
}
