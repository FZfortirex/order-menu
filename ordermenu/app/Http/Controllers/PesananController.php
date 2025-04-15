<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PesananController extends Controller
{
    public function tambah(Request $request)
    {
        $item = $request->only(['name', 'price', 'category', 'desc', 'img']);

        $pesanan = session()->get('pesanan', []);

        $key = array_search($item['name'], array_column($pesanan, 'name'));

        if ($key !== false) {
            $pesanan[$key]['quantity'] += 1;
        } else {
            $item['quantity'] = 1;
            $pesanan[] = $item;
        }

        session(['pesanan' => $pesanan]);

        return response()->json(['message' => 'Ditambahkan ke Pesanan Saya']);
    }

    // Hapus item dari pesanan
    public function remove($nama)
    {
        $pesanan = Session::get('pesanan', []);

        // Filter item yang bukan yang dihapus
        $pesanan = array_filter($pesanan, function ($item) use ($nama) {
            return $item['name'] !== $nama;
        });

        Session::put('pesanan', $pesanan);

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    // Submit pesanan
    public function submit(Request $request)
    {
        $request->validate([
            'meja' => 'required',
            'catatan' => 'nullable|string',
            'voucher' => 'nullable|string',
        ]);

        $pesanan = Session::get('pesanan', []);
        $total = 0;

        foreach ($pesanan as $item) {
            $subtotal = preg_replace('/[^0-9]/', '', $item['price']) * $item['quantity'];
            $total += $subtotal;
        }

        // Simulasi simpan ke database (buat model kalau mau disimpan beneran)
        // Misalnya: Order::create([...]);

        // Kosongkan pesanan setelah submit
        Session::forget('pesanan');

        return redirect()->back()->with('success', 'Pesanan berhasil dikirim!');
    }

    public function index()
    {
        $pesanan = session('pesanan', []);
        return view('order.pesanan-saya', compact('pesanan'));
    }
}