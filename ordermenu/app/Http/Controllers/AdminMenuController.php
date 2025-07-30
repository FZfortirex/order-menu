<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class AdminMenuController extends Controller
{
    // Menampilkan semua menu
    public function index()
    {
        $menus = Menu::all();
        return view('admin.admin-menu', compact('menus'));
    }

    // Menampilkan form tambah menu
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
    $menu->point = $request->point;
    $menu->category = $request->category;

    // Cek apakah ada file image baru diupload
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($menu->image && file_exists(public_path('storage/' . $menu->image))) {
            unlink(public_path('storage/' . $menu->image));
        }

        $imagePath = $request->file('image')->store('menus', 'public');
        $menu->image = $imagePath;
    }

    $menu->save(); // Simpan ke database

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
