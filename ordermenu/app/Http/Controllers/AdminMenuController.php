<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Jenssegers\Agent\Agent;

class AdminMenuController extends Controller
{
    // Menampilkan semua menu
    public function index()
    {
        $menus = Menu::where('status', 'sedia')->get();
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        $view = $isMobile ? 'admin.admin-menu-mobile' : 'admin.admin-menu';

        return view($view, compact('menus'));
    }

    // Menampilkan form tambah menu
    public function adminMenu()
{
    $menus = Menu::all();

    return view('admin.admin-menu', compact('menus'));
}

public function create()
{
    $agent = new Agent();

    if ($agent->isMobile()) {
        return view('admin.create-mobile');
    }

    return view('admin.create'); 
}

public function edit($id)
{
    $menu = Menu::findOrFail($id);
    return view('admin.edit', compact('menu'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'discount_price' => 'nullable|numeric|lt:price',
        'desc' => 'nullable|string',
        'category' => 'required|string',
        'stock' => 'required|integer|min:0',
        'point' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $menu = Menu::findOrFail($id);

    $menu->name = $request->name;
    $menu->price = $request->price;
    $menu->discount_price = $request->discount_price;
    $menu->desc = $request->desc;
    $menu->stock = $request->stock;
    $menu->point = $request->point;
    $menu->category = $request->category;

    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($menu->image && file_exists(public_path('images/' . $menu->image))) {
            unlink(public_path('images/' . $menu->image));
        }

        // Simpan gambar baru
        $nameSlug = strtolower(str_replace(' ', '_', $request->name));
        $extension = $request->image->getClientOriginalExtension();
        $imageName = $nameSlug . '.' . $extension;

        $request->image->move(public_path('images'), $imageName);
        $menu->image = $imageName;
    }

    // Cek apakah image kosong dan coba isi default
    if (!$menu->image) {
        $slugName = strtolower(str_replace(' ', '_', $menu->name));
        $defaultImagePath = public_path("images/{$slugName}.jpg");

        if (file_exists($defaultImagePath)) {
            $menu->image = "{$slugName}.jpg";
        }
    }

    $menu->save();

    return redirect()->route('admin.menu')->with('success', 'Menu berhasil diupdate!');
}

public function delete($id)
{
    $menu = Menu::findOrFail($id);
    $menu->status = 'tidak sedia';
    $menu->save();

    return redirect()->route('admin.menu')->with('success', 'Menu berhasil dihapus!');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'discount_price' => 'nullable|numeric|lt:price',
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
        'discount_price' => $request->discount_price,
        'desc' => $request->desc,
        'category' => $request->category,
        'stock' => $request->stock,
        'point' => $request->point,
        'image' => $imageName,
    ]);

    return redirect()->route('admin.menu')->with('success', 'Menu berhasil ditambahkan!');
}

}