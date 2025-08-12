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

            if (!$sessionIdInDb || $sessionIdInDb !== $sessionIdInSession) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('qr.login')->with('error', 'Sesi anda telah digantikan oleh login baru.');
            }

            // 2. Jika expired → logout
            if ($expiry && Carbon::now()->greaterThan($expiry)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('qr.login')->with('error', 'Sesi anda sudah berakhir, silakan scan QR lagi.');
            }
        }

        return $next($request);
    }
}