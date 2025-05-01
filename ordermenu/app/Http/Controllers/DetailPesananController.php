<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function list()
    {
        // Jika ada data dinamis, bisa dikirim dari sini ke view
        return view('admin.detail-pesanan'); // Pastikan nama file Blade-nya listpesanan.blade.php
    }
}
