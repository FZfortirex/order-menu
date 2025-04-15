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
}