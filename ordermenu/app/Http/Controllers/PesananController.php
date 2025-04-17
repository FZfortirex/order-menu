<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Item;

class PesananController extends Controller
{
    // Tambah item ke pesanan
    public function add(Request $request)
    {
        $request->validate([
            'menu_id'   => 'required|exists:menus,id',
            'packaging' => 'required|string',
            'note'      => 'nullable|string',
            'quantity'  => 'required|integer|min:1',
            'price'     => 'required|numeric',
        ]);

        // Hitung total harga item (price * quantity)
        $totalItemPrice = $request->price * $request->quantity;

        // Simpan item ke database
        Item::create([
            'user_id'     => auth()->id(), // Pastikan user login
            'menu_id'     => $request->menu_id,
            'packaging'   => $request->packaging,
            'note'        => $request->note,
            'quantity'    => $request->quantity,
            'items_price' => $totalItemPrice, // ⬅️ total harga dari item
        ]);

        return redirect('/menu')->with('success', 'Item berhasil ditambahkan ke pesanan.');
    }

    // Hapus item dari pesanan berbasis session
    public function remove($nama)
    {
        $pesanan = Session::get('pesanan', []);

        // Filter item yang berbeda dari yang ingin dihapus
        $filtered = array_filter($pesanan, function ($item) use ($nama) {
            return $item['name'] !== $nama;
        });

        Session::put('pesanan', $filtered);

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    // Kirim pesanan (hanya berlaku jika menggunakan session)
    public function submit(Request $request)
    {
        $request->validate([
            'meja'    => 'required|string',
            'catatan' => 'nullable|string',
            'voucher' => 'nullable|string',
        ]);

        $userId = auth()->id();
        $items = Item::where('user_id', $userId)->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pesanan untuk dikirim.');
        }

        // Hitung total harga dari semua item
        $totalHarga = $items->sum('items_price');

        // Buat order baru di tabel orders
        $order = Order::create([
            'user_id'         => $userId,
            'redeem_point_id' => null, // bisa disesuaikan nanti
            'table'           => $request->meja,
            'additional_note' => $request->catatan,
            'total_price'     => $totalHarga,
            'status'          => 'menunggu', // status default
            'total_point'     => 0, // kalau belum ada sistem poin
        ]);

        // Kosongkan pesanan user (hapus dari table items)
        Item::where('user_id', $userId)->delete();

        return redirect('/menu')->with('success', 'Pesanan berhasil dikirim!');
    }

    // Tampilkan daftar pesanan (session-based)
    public function index()
    {
        $userId = Auth::id();
        $pesanan = Item::where('user_id', $userId)->with('menu')->get();

        // Format data untuk ditampilkan di view
        $pesanan = $pesanan->map(function ($item) {
            return [
                'name'         => $item->menu->name ?? 'Menu Tidak Ditemukan',
                'desc'         => $item->note ?? '',
                'quantity'     => $item->quantity,
                'items_price'  => $item->items_price, // ✅ Tambahkan ini
                'total_price'  => 'Rp. ' . number_format($item->items_price, 0, ',', '.'),
            ];
        });
        
        $total = $pesanan->sum('items_price');

        return view('order.pesanan-saya', compact('pesanan', 'total'));        
    }
}
