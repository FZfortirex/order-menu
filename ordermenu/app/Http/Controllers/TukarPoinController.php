<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TukarPoin;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TukarPoinController extends Controller
{
    public function index()
    {
        $rewards = Reward::all();
        $user = auth()->user();
        return view('user.tukar-poin-desktop', compact('rewards', 'user'));
    }

    public function tukar(Request $request, $id)
    {
        $reward = Reward::findOrFail($id);
        $user = Auth::user();

        if ($user->poin < $reward->poin_dibutuhkan) {
            return redirect()->back()->with('error', 'Poin tidak cukup untuk menukar reward ini.');
        }

        // Kurangi poin user
        $user->poin -= $reward->poin_dibutuhkan;
        $user->save();

        // Simpan riwayat penukaran
        TukarPoin::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
        ]);

        return redirect()->back()->with('success', 'Berhasil menukar poin dengan reward: ' . $reward->nama);
    }

    public function riwayat()
    {
        $riwayat = TukarPoin::where('user_id', Auth::id())->with('reward')->latest()->get();
        return view('tukar-poin.riwayat', compact('riwayat'));
    }
}
