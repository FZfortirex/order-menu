<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order; 
use App\Models\Item;
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

        $user = User::where('name', $nomorMeja)
            ->where('role', 'customer')
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Meja tidak tersedia.');
        }

        $expiredAt = $user->session_expired_at
            ? ($user->session_expired_at instanceof Carbon
                ? $user->session_expired_at
                : Carbon::parse($user->session_expired_at))
            : null;

        if ($user->status === 'terisi' && $expiredAt && $expiredAt->isFuture()) {
            return redirect('/welcome')->with('error', 'Meja sedang digunakan.');
        }

        if ($expiredAt && $expiredAt->isPast()) {
            $user->status = 'kosong';
            $user->current_session_id = null;
            $user->session_expired_at = null;
            $user->save();
        }

        $newSessionId = Str::uuid()->toString();

        $user->current_session_id = $newSessionId;
        $user->session_expired_at = Carbon::now()->addMinutes(30);
        $user->status = 'terisi'; 
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user->id) {
            Item::where('user_id', $user->id)
                ->whereNull('order_id')
                ->delete();
        }

        session([
            'meja' => $nomorMeja,
            'current_session_id' => $newSessionId
        ]);

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

        if ($user && ( $credentials['password'] === $user->password || Hash::check($credentials['password'], $user->password) )) {
            // Login user
            auth()->loginUsingId($user->id); 
            $request->session()->regenerate();

            // Reset flag lama
            Session::forget(['admin_logged_in', 'customer_logged_in']);

            if ($user->role === 'admin') {
                Session::put('admin_logged_in', true);
                return redirect()->route('dashboard');
            } elseif ($user->role === 'customer') {
                Session::put('customer_logged_in', true);

                // 🔥 Mirip QR Scan: generate session id baru
                $newSessionId = Str::uuid()->toString();
                $user->current_session_id = $newSessionId;
                $user->session_expired_at = Carbon::now()->addMinutes(30);
                $user->save();

                // 🔥 Kalau ada session meja dari QR, pakai itu.
                // Kalau tidak ada, fallback pakai nama user
                if (!session()->has('meja')) {
                    session(['meja' => $user->name]);
                }

                // Update session id
                session(['current_session_id' => $newSessionId]);

                return redirect()->route('order.menu');
            } else {
                return redirect()->route('home');
            }
        }

        // Jika gagal
        session()->put('login_attempt', [
            'username' => $credentials['username'],
            'status' => 'failed',
            'timestamp' => now(),
        ]);

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
