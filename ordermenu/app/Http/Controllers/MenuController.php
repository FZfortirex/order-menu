<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        //Data menu sementara (nanti bisa di ganti dengan database)
        $menus = [
            ['nama' => 'Ayam geprek',
             'deskripsi' => 'ayam geprek khas',
              'harga' => 10000,
             'gambar' => '',
        ],
            ['nama' => 'Ayam Bakar',
            'deskripsi' => 'Ayam bakar dengan bumbu khas',
            'harga' => 12000,
            'gambar' => '',
            ],
            ['nama' => 'Lele gorengr',
            'deskripsi' => 'kan lele goreng renyah',
            'harga' => 10000,
            'gambar' => '',
            ],
            ['nama' => 'Nasi goreng',
            'deskripsi' => 'Nasi goreng spesial',
            'harga' => 15000,
            'gambar' => '',
            ],
        ];

        return view('order.menu', compact('menus'));
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
