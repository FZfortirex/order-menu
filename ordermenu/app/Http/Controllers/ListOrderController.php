<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Mobile_Detect;
use Jenssegers\Agent\Agent; // Tambahkan package ini
use App\Models\Order; 
//use App\Models\Order; // Pastikan model Order sudah ada

class ListOrderController extends Controller
{
    public function index(Request $request) {
        // Cek apakah admin sudah login
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }
        // Data dummy untuk sementara
        $orders = Order::all();

        // Hitung jumlah meja yang sudah digunakan
        $usedTables = $orders->count();

        // Total meja yang tersedia
        $totalTables = 36; 
        
        // Jumlah meja yang tersedia
        $availableTables = $totalTables - $usedTables;

        $agent = new Agent();
        $userAgent = $request->header('User-Agent');

        // Ganti $detect jadi $agent
    if ($agent->isMobile()) {
        return view('admin.list-order-mobile', compact('orders', 'availableTables', 'totalTables'));
    } else {
        return view('admin.list-order-desktop', compact('orders', 'availableTables', 'totalTables'));
    }
    }
}
