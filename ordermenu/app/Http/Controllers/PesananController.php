<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\User;
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

        // Hitung total harga item
        $totalItemPrice = $request->price * $request->quantity;

        // Simpan item ke database
        Item::create([
            'user_id'     => auth()->id(), // user login
            'menu_id'     => $request->menu_id,
            'packaging'   => $request->packaging,
            'note'        => $request->note,
            'quantity'    => $request->quantity,
            'items_price' => $totalItemPrice, // total harga dari item
        ]);

        return redirect('/menu')->with('success', 'Item berhasil ditambahkan ke pesanan.');
    }

    // Hapus item dari pesanan
    public function remove($nama)
{
    $userId = auth()->id();

    $item = Item::whereHas('menu', function ($query) use ($nama) {
        $query->where('name', $nama);
    })->where('user_id', $userId)
      ->whereNull('order_id') // pastikan hanya yang belum dikirim
      ->first();

    if ($item) {
        $item->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    return redirect()->back()->with('error', 'Item tidak ditemukan atau sudah dikirim.');
}


    // Kirim pesanan
    public function submit(Request $request)
    {
        $request->validate([
            'meja'    => 'required|string',
            'catatan' => 'nullable|string',
            'voucher' => 'nullable|string',
        ]);

        $userId = auth()->id();

        $items = Item::where('user_id', $userId)
            ->whereNull('order_id')
            ->with('menu') // pastikan menu ikut diambil
            ->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pesanan untuk dikirim.');
        }

        // Hitung total harga
        $totalHarga = $items->sum('items_price');

        // Hitung total point dari menu.point * quantity
        $totalPoint = $items->sum(function ($item) {
            return optional($item->menu)->point * $item->quantity;
        });

        // Buat order
        $order = Order::create([
            'user_id'         => $userId,
            'redeem_point_id' => null,
            'table'           => $request->meja,
            'additional_note' => $request->catatan,
            'total_price'     => $totalHarga,
            'status'          => 'menunggu',
            'total_point'     => $totalPoint,
        ]);

        // Update item
        Item::where('user_id', $userId)
            ->whereNull('order_id')
            ->update(['order_id' => $order->id]);

        // Tambahkan poin ke user
        $user = User::find($userId);
        $user->my_points += $totalPoint;
        $user->save();

        return redirect('/menu')->with('success', 'Pesanan berhasil dikirim! Kamu dapat ' . $totalPoint . ' poin.');
    }


    // Tampilkan daftar pesanan
    public function index()
    {
        $userId = Auth::id();
        $pesanan = Item::where('user_id', $userId)->with('menu')->get();

        // Format data untuk ditampilkan di view
        $pesanan = $pesanan->map(function ($item) {
            return [
                'name'         => $item->menu->name ?? 'Menu Tidak Ditemukan',
                'desc'         => $item->note ?? '',
                'packaging'    => $item->packaging ?? '-',
                'note'         => $item->note ?? '-',
                'quantity'     => $item->quantity,
                'items_price'  => $item->items_price,
                'total_price'  => 'Rp. ' . number_format($item->items_price, 0, ',', '.'),
            ];
        });


        $total = $pesanan->sum('items_price');

        return view('order.pesanan-saya', compact('pesanan', 'total'));
    }
}
