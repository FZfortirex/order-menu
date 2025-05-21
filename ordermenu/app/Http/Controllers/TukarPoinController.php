<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserDiscount;
use Illuminate\Support\Facades\Auth;

class TukarPoinController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $rewards = Reward::where(function ($query) {
            $query->whereNull('stock')->orWhere('stock', '>', 0);
        })->get();

        return view('user.tukar-poin-desktop', compact('user', 'rewards'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $reward = Reward::findOrFail($request->reward_id);

        if ($user->my_points < $reward->points_required) {
            return redirect()->back()->with('error', 'Poin kamu tidak cukup.');
        }

        if (!is_null($reward->stock) && $reward->stock <= 0) {
            return redirect()->back()->with('error', 'Stok reward habis.');
        }

        $user->my_points -= $reward->points_required;
        $user->save();

        if (!is_null($reward->stock)) {
            $reward->stock -= 1;
            $reward->save();
        }

        UserDiscount::create([
            'user_id'   => $user->id,
            'reward_id' => $reward->id,
            'is_used'   => false,
            'order_id'  => null, 
        ]);

        return redirect()->back()->with('success', 'Reward berhasil ditukar!');
    }
}
