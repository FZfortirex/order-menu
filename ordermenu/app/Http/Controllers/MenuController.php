<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        // Menampilkan semua menu
        $menus = Menu::all();
        return view('order.menu', compact('menus'));
    }

    public function apiMenus()
    {
        $menus = Menu::withAvg('reviews', 'rating')->get();

        // Rename agar tetap bisa diakses sebagai 'rating' di frontend
        $menus->each(function ($menu) {
            $menu->rating = round($menu->reviews_avg_rating ?? 0, 1);
            unset($menu->reviews_avg_rating);
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

    public function adminMenu()
{
    $menus = Menu::all();
    return view('admin.admin-menu', compact('menus'));
}

public function create()
{
    return view('admin.create'); // atau sesuaikan dengan view yang kamu punya
}

public function edit($id)
{
    $menu = Menu::findOrFail($id);
    return view('admin.edit', compact('menu'));
}

public function update(Request $request, $id)
{
    $menu = Menu::findOrFail($id);

    $menu->name = $request->name;
    $menu->price = $request->price;
    $menu->desc = $request->desc;
    $menu->stock = $request->stock;



    $menu->save(); // ← WAJIB! Simpan ke database

    return redirect()->route('admin.menu')->with('success', 'Menu berhasil diupdate');
}




public function destroy($id)
{
    $menu = Menu::findOrFail($id);
    $menu->delete();

    return redirect()->route('admin.menu')->with('success', 'Menu berhasil dihapus!');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'desc' => 'nullable|string',
        'category' => 'required|string',
        'stock' => 'required|integer|min:0',
        'point' => 'required|integer|min:0',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $nameSlug = strtolower(str_replace(' ', '_', $request->name));

    $extension = $request->image->getClientOriginalExtension();

    $imageName = $nameSlug . '.' . $extension;

    $request->image->move(public_path('images'), $imageName);

    Menu::create([
        'name' => $request->name,
        'price' => $request->price,
        'desc' => $request->desc,
        'category' => $request->category,
        'stock' => $request->stock,
        'point' => $request->point,
        'image' => $imageName,
    ]);

    return redirect()->route('admin.menu')->with('success', 'Menu berhasil ditambahkan!');
}

}