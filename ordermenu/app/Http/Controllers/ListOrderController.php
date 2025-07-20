<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Mobile_Detect;
use Jenssegers\Agent\Agent; // Tambahkan package ini
use App\Models\Order;
use Carbon\Carbon;

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

        $salesByDay = array_fill(0, 7, 0);
        $completedOrdersByDay = array_fill(0, 7, 0);

        foreach ($orders as $order) {
            if ($order->updated_at) {
                $dayIndex = Carbon::parse($order->updated_at)->dayOfWeek;

                if (strtolower($order->status) === 'selesai') {
                    $completedOrdersByDay[$dayIndex] += 1;
                    if ($order->total_price) {
                        $salesByDay[$dayIndex] += $order->total_price;
                    }
                }
            }
        }

        $orderedSales = [
            $salesByDay[1], 
            $salesByDay[2],
            $salesByDay[3],
            $salesByDay[4],
            $salesByDay[5],
            $salesByDay[6],
            $salesByDay[0], 
        ];

        $orderedCompletedOrders = [
            $completedOrdersByDay[1], 
            $completedOrdersByDay[2],
            $completedOrdersByDay[3],
            $completedOrdersByDay[4],
            $completedOrdersByDay[5],
            $completedOrdersByDay[6],
            $completedOrdersByDay[0], 
        ];

        $agent = new Agent();
        $userAgent = $request->header('User-Agent');

        if ($agent->isMobile()) {
            return view('admin.list-order-mobile', compact('orders', 'availableTables', 'totalTables', 'orderedSales', 'orderedCompletedOrders'));
        } else {
            return view('admin.list-order-desktop', compact('orders', 'availableTables', 'totalTables', 'orderedSales', 'orderedCompletedOrders'));
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
