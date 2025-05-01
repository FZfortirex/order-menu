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
        // Data dummy orders
        $orders = collect([
            (object)[
                'id' => 1,
                'table_number' => 5,
                'antrian' => 10,
                'status' => 'ongoing',
            ],
            (object)[
                'id' => 2,
                'table_number' => 12,
                'antrian' => 11,
                'status' => 'finished',
            ],
            (object)[
                'id' => 3,
                'table_number' => 20,
                'antrian' => 12,
                'status' => 'ongoing',
            ],
            // Tambahkan data lain kalau mau
        ]);

        // Hitung jumlah meja yang sudah digunakan
        $usedTables = $orders->count();

        // Total meja yang tersedia
        $totalTables = 36;

        // Jumlah meja yang tersedia
        $availableTables = $totalTables - $usedTables;

        $agent = new Agent();
        $userAgent = $request->header('User-Agent');

        if ($agent->isMobile()) {
            return view('admin.list-order-mobile', compact('orders', 'availableTables', 'totalTables'));
        } else {
            return view('admin.list-order-desktop', compact('orders', 'availableTables', 'totalTables'));
        }
    }
}
