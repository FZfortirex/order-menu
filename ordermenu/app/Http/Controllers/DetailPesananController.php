<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DetailPesananController extends Controller
{

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.detail-pesanan', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order = Order::with('items.menu')->findOrFail($order->id);

        $request->validate([
            'status' => 'required|in:sedang dibuat,sudah dibuat',
        ]);

        if ($request->status === 'sudah dibuat' && $order->status !== 'sudah dibuat') {
            foreach ($order->items as $item) {
                $menu = $item->menu;
                if ($menu && $menu->stock >= $item->quantity) {
                    $menu->stock -= $item->quantity;
                    $menu->save();
                }
            }
        }

        // Update status pesanan
        $order->status = $request->status;
        $order->save();

        return redirect()->route('order.detail', $order->id)
                         ->with('success', 'Status pesanan telah diperbarui!');
    }

    public function done(Order $order)
    {
        $user = $order->user;
        $totalPoint = 0;

        foreach ($order->items as $item) {
            $totalPoint += $item->menu->point ?? 0;
        }

        $user->my_points += $totalPoint;
        $user->save();

        $order->items()->delete();
        $order->delete();

        return redirect()->route('dashboard')->with('success', 'Pesanan selesai dan poin ditambahkan.');
    }
}
