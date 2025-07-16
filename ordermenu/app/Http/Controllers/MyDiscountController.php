<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Reward;
use App\Models\UserDiscount;

class MyDiscountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $userDiscountsGrouped = UserDiscount::where('user_id', $user->id)
            ->where('is_used', 0)
            ->with(['reward', 'order']) 
            ->get()
            ->groupBy('reward_id')
            ->map(function ($group) {
                $first = $group->first(); 

                return (object)[
                    'reward_id' => $first->reward_id, 
                    'reward'    => $first->reward,
                    'total'     => $group->count(),
                    'order'     => $first->order,
                    'is_used'   => $first->is_used,
                ];
            })
            ->values();

        return view('user.my-discount', ['userDiscountsGrouped' => $userDiscountsGrouped]);
    }
}
