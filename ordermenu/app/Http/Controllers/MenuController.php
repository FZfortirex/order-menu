<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

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
        return response()->json(Menu::all());
    }

    public function makanan()
    {
        $menus = [
            [
                'nama' => 'Ayam Geprek',
                'deskripsi' => 'Ayam Goreng dengan Geprekan khasnya',
                'harga' => 10000,
                'gambar' => 'ayam-geprek.png',
            ],
            [
                'nama' => 'Ayam Bakar',
                'deskripsi' => 'Ayam panggang dengan bumbu khas',
                'harga' => 12000,
                'gambar' => 'ayam-bakar.png',
            ]
        ];

        return view('order.makanan', compact('menus'));
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
        $menu = Menu::findOrFail($id);

        $menus = Menu::where('id', '!=', $id)
                     ->inRandomOrder()
                     ->limit(3)
                     ->get();

        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        return view($isMobile ? 'order.option-menu-mobile' : 'order.option-menu-desktop', compact('menu', 'menus'));
    }
}