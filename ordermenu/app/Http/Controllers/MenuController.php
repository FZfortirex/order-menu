<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Banner;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $banners = Banner::whereNotNull('image')->get();
        $menus = Menu::all();

        return view('order.menu', compact('banners', 'menus'));
    }

    public function apiMenus()
    {
        $menus = Menu::withAvg('reviews', 'rating')
                    ->withCount('reviews') 
                    ->get();

        $menus->each(function ($menu) {
            $menu->rating = round($menu->reviews_avg_rating ?? 0, 1);
            $menu->review_count = $menu->reviews_count ?? 0;

            unset($menu->reviews_avg_rating);
            unset($menu->reviews_count);
        });

        return response()->json($menus);
    }

    public function makanan()
    {
        return view('order.makanan');
    }

    public function minuman()
    {
        return view('order.minuman');
    }

    public function cemilan()
    {
        return view('order.cemilan');
    }

    public function show(Request $request, $id)
    {
        // Ambil menu berdasarkan ID atau gagal jika tidak ditemukan
        $menu = Menu::findOrFail($id);

        // Ambil 3 menu acak lainnya, kecuali yang sedang ditampilkan
        $menus = Menu::where('id', '!=', $id)
                    ->inRandomOrder()
                    ->limit(6)
                    ->get();

        $userId = auth()->id();
        $order = Order::where('user_id', $userId)
                    ->latest()
                    ->first();
        $status = $order ? $order->status : null;

        // Deteksi apakah perangkat yang digunakan adalah mobile
        $userAgent = $request->header('User-Agent');
        $isMobile = $userAgent && preg_match('/Mobile|Android|iPhone|iPad/', $userAgent);

        // Tampilkan view sesuai perangkat
        $view = $isMobile ? 'order.option-menu-mobile' : 'order.option-menu-desktop';

        return view($view, compact('menu', 'menus', 'status'));
    }
}