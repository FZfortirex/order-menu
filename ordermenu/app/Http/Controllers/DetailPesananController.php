<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UserDiscount;
use Jenssegers\Agent\Agent;

class DetailPesananController extends Controller
{

    public function show($id)
    {
        $order = Order::with(['items.menu', 'userDiscount.reward'])->findOrFail($id);

        foreach ($order->items as $item) {
            $filename = strtolower(str_replace(' ', '_', $item->menu->name)) . '.jpg';
            $imagePath = public_path('images/' . $filename);
            $item->image_url = file_exists($imagePath)
                ? asset('images/' . $filename)
                : asset('images/default.png');
        }

        $agent = new Agent();

        if ($agent->isMobile()) {
            return view('admin.detail-pesanan-mobile', compact('order'));
        }

        return view('admin.detail-pesanan', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order = Order::with('items.menu', 'user')->findOrFail($order->id);

        $request->validate([
            'status' => 'required|in:sedang dibuat,sudah dibuat',
        ]);

        if ($request->status === 'sedang dibuat' && $order->status !== 'sedang dibuat') {
            foreach ($order->items as $item) {
                $menu = $item->menu;

                if (!$menu || $menu->stock < $item->quantity) {
                    return back()->with('error', 'Stok untuk "' . $menu->name . '" tidak mencukupi.');
                }
            }

            foreach ($order->items as $item) {
                $menu = $item->menu;
                $menu->stock -= $item->quantity;
                $menu->save();
            }
        }

        if ($request->status === 'sudah dibuat') {
            $user = $order->user;
            if ($user) {
                $user->status = 'kosong'; 
                $user->current_session_id = null;
                $user->session_expired_at = null;
                $user->save();

                if (Auth::id() === $user->id) {
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                }
            }
        }

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

        $order->status = 'selesai';
        $order->save();

        UserDiscount::where('order_id', $order->id)->update(['is_used' => 1]);

        return redirect()->route('dashboard')->with('success', 'Pesanan selesai dan poin ditambahkan.');
    }
}
