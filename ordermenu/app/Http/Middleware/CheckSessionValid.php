<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckSessionValid
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role === 'customer') {
            $sessionIdInDb = $user->current_session_id;
            $sessionIdInSession = session('current_session_id');
            $expiry = $user->session_expired_at;

            // 1. Pastikan customer punya session id
            if (!$sessionIdInDb || !$sessionIdInSession) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('qr.login')
                    ->with('error', 'Anda harus login melalui QR Code.');
            }

            // ❌ Hapus bagian "Jika session ID beda (tabrakan login)"
            // Karena sekarang kita tolak login baru di AuthController,
            // jadi user lama ga perlu ditendang.

            // 2. Jika sesi expired
            if ($expiry && Carbon::now()->greaterThan($expiry)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('qr.login')
                    ->with('error', 'Sesi anda sudah berakhir, silakan scan QR lagi.');
            }

            // 3. Pastikan session meja tetap ada
            if (!session()->has('meja')) {
                session(['meja' => $user->name]); 
                // fallback kalau login manual tanpa QR
            }
        }

        return $next($request);
    }
}
