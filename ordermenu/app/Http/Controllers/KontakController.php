<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class KontakController extends Controller
{

    public function index(Request $request)
    {
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        return view($isMobile ? 'user.kontak-mobile' : 'user.kontak-desktop');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_phone' => 'nullable|numeric',
            'email' => 'nullable|email',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'number_phone' => $request->number_phone,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->route('kontak')->with('success', 'Pesan Anda berhasil dikirim!');
    }
}
