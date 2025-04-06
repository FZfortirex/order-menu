<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        return view($isMobile ? 'welcome-mobile' : 'welcome-desktop');
    }
}
