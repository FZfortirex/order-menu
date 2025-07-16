<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $isMobile = $request->header('User-Agent') &&
            preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        $user = auth()->user();

        $orders = Order::where('status', 'selesai')
            ->where('user_id', $user->id)
            ->with('user') // cukup relasi ke user
            ->get();

        return view(
            $isMobile ? 'user.profile-mobile' : 'user.profile-desktop',
            compact('user', 'orders')
        );
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.menu'])
                    ->where('status', 'selesai')
                    ->findOrFail($id);

        foreach ($order->items as $item) {
            $menuName = $item->menu->name ?? 'default';
            $filename = strtolower(str_replace(' ', '_', $menuName)) . '.jpg';
            $imagePath = public_path('images/' . $filename);

            $image = file_exists($imagePath)
                ? asset('images/' . $filename)
                : asset('images/default.png');

            $item->image = $image;
        }

        return view('user.history-desktop', compact('order'));
    }
}
