<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));
        $user = auth()->user();
        return view($isMobile ? 'user.profile-mobile' : 'user.profile-desktop', compact('user')); //compact mengirimkan $user ke view.
    }
}
