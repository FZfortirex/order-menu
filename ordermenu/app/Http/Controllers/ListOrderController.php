<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Mobile_Detect;
use Jenssegers\Agent\Agent; // Tambahkan package ini
//use App\Models\Order; // Pastikan model Order sudah ada

class ListOrderController extends Controller
{
    public function index(Request $request) {
        // Cek apakah admin sudah login
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }
        // Data dummy untuk sementara
        $orders = [
            [
                'name' => 'Customer 1',
                'table' => '5',
                'total_price' => '40rb'
            ],
            [
                'name' => 'Customer 2',
                'table' => '3',
                'total_price' => '50rb'
            ],
            [
                'name' => 'Customer 3',
                'table' => '7',
                'total_price' => '60rb'
            ],
        ];
        $agent = new Agent();
        $userAgent = $request->header('User-Agent');

        // Ganti $detect jadi $agent
    if ($agent->isMobile()) {
        return view('admin.list-order-mobile', compact('orders'));
    } else {
        return view('admin.list-order-desktop', compact('orders'));
    }
    }
}
