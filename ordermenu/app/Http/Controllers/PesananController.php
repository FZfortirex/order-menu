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
    public function add(Request $request)
    {
        $request->validate([
            'menu_id'   => 'required|exists:menus,id',
            'packaging' => 'required|string',
            'note'      => 'nullable|string',
            'quantity'  => 'required|integer|min:1',
            'price'     => 'required|numeric',
        ]);

        $totalItemPrice = $request->price * $request->quantity;

        Item::create([
            'user_id'     => auth()->id(), 
            'menu_id'     => $request->menu_id,
            'packaging'   => $request->packaging,
            'note'        => $request->note,
            'quantity'    => $request->quantity,
            'items_price' => $totalItemPrice, 
        ]);

        return redirect('/menu')->with('success', 'Item berhasil ditambahkan ke pesanan.');
    }

    public function remove($nama)
    {
        $userId = auth()->id();

        $item = Item::whereHas('menu', function ($query) use ($nama) {
            $query->where('name', $nama);
        })->where('user_id', $userId)
        ->whereNull('order_id')
        ->first();

        if ($item) {
            $item->delete();
            return redirect()->back()->with('success', 'Item berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan atau sudah dikirim.');
    }

    public function cancel($id)
    {
        $userId = auth()->id();

        $order = Order::where('id', $id)
                  ->where('user_id', $userId)
                  ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan atau tidak bisa dibatalkan.');
        }

        Item::where('order_id', $order->id)->delete();

        $order->delete();

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function resetPesanan()
    {
        $user = auth()->user();
        
        Item::where('user_id', $user->id)
            ->whereNull('order_id')
            ->delete();

        return redirect('/menu');
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

        return redirect('/menu')->with('success', 'Pesanan berhasil dikirim! Kamu dapat ' . $totalPoint . ' poin.')->with('order', $order);
    }


    public function index()
    {
        $userId = Auth::id();

        $pesanan = Item::where('user_id', $userId)
                    ->where(function ($query) {
                        $query->whereNull('order_id')
                            ->orWhereHas('order', function ($q) {
                                $q->where('status', '!=', 'selesai');
                            });
                    })
                    ->with('menu')
                    ->get();

        $pesanan = $pesanan->map(function ($item) {
            $filename = strtolower(str_replace(' ', '_', $item->menu->name)) . '.jpg';
            $imagePath = public_path('images/' . $filename);
            
            $image = file_exists($imagePath) ? asset('images/' . $filename) : asset('images/default.png');

            return [
                'name'         => $item->menu->name ?? 'Menu Tidak Ditemukan',
                'desc'         => $item->note ?? '',
                'packaging'    => $item->packaging ?? '-',
                'note'         => $item->note ?? '-',
                'quantity'     => $item->quantity,
                'items_price'  => $item->items_price,
                'total_price'  => 'Rp. ' . number_format($item->items_price, 0, ',', '.'),
                'image'        => $image, 
            ];
        });

        $total = $pesanan->sum('items_price');

        $currentOrder = Order::where('user_id', $userId)
                        ->latest()
                        ->first();

        $status = $currentOrder ? $currentOrder->status : null;
        $currentOrderId = $currentOrder ? $currentOrder->id : null;

        $order = Order::where('user_id', auth()->id())->latest()->first();

        return view('order.pesanan-saya', [
            'order' => $order,
            'pesanan' => $pesanan, 
            'status' => $order->status ?? null, 
            'currentOrderId' => $order->id ?? null, 
            'total' => $total, 
        ]);
    }
}
