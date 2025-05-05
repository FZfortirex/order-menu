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
        
        $orders = Order::all();

        $activeOrders = $orders->filter(function ($order) {
            return strtolower($order->status) !== 'selesai';
        });
        
        $usedTables = $activeOrders->pluck('table')->filter()->unique()->count();

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

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Order berhasil dihapus.');
    }

    public function showWaiting()
    {
        $listOrder = Order::where('status', 'menunggu')->get();
        $availableTables = $this->getAvailableTables();
        $totalTables = $this->getTotalTables();
        return view('listOrder.process', compact('listOrder', 'availableTables', 'totalTables'));
    }

    public function showProcess()
    {
        $listOrder = Order::where('status', 'sedang dibuat')->get();
        $availableTables = $this->getAvailableTables();
        $totalTables = $this->getTotalTables();
        return view('listOrder.process', compact('listOrder', 'availableTables', 'totalTables'));
    }

    public function showComplete()
    {
        $listOrder = Order::where('status', 'sudah dibuat')->get();
        $availableTables = $this->getAvailableTables();
        $totalTables = $this->getTotalTables();
        return view('listOrder.complete', compact('listOrder', 'availableTables', 'totalTables'));
    }
}
