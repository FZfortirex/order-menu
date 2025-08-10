<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use App\Models\UserDiscount;
use Detection\MobileDetect;

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
            'discount_price' => 'nullable|numeric',
        ]);

        $hargaPerItem = $request->discount_price ?? $request->price;
        $totalItemPrice = $hargaPerItem * $request->quantity;

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

        if ($order->user_discount_id) {
        UserDiscount::where('id', $order->user_discount_id)->update([
            'is_used' => false,
            'order_id' => null,
        ]);
    }

        Item::where('order_id', $order->id)->delete();

        $order->delete();

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Kirim pesanan
    public function submit(Request $request)
    {
        $mejaSession = session('meja');

        $request->validate([
            'meja'    => $mejaSession ? 'nullable' : 'required|string',
            'catatan' => 'nullable|string',
            'voucher' => 'nullable|string',
        ]);

        $userId = auth()->id();

        $items = Item::where('user_id', $userId)
            ->whereNull('order_id')
            ->with('menu')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pesanan untuk dikirim.');
        }

        $totalHarga = $items->sum(function ($item) {
            return ($item->items_price ?? 0) * ($item->quantity ?? 1);
        });

        $totalPoint = $items->sum(function ($item) {
            return optional($item->menu)->point * $item->quantity;
        });

        $userDiscountId = null;
        if ($request->voucher) {
            $userDiscount = UserDiscount::where('user_id', $userId)
                ->whereHas('reward', function ($query) use ($request) {
                    $query->where('name', $request->voucher);
                })
                ->where('is_used', false)
                ->first();

            if (!$userDiscount) {
                return redirect()->back()->with('error', 'Voucher tidak valid atau sudah digunakan.');
            }

            $userDiscountId = $userDiscount->id;
        }

        $meja = $mejaSession ?? $request->meja;

        $order = Order::create([
            'user_id'          => $userId,
            'user_discount_id' => $userDiscountId,
            'table'            => $meja,
            'total_price'      => $request->final_total,
            'status'           => 'menunggu',
            'total_point'      => $totalPoint,
        ]);

        Item::where('user_id', $userId)
            ->whereNull('order_id')
            ->update(['order_id' => $order->id]);

        if ($userDiscountId) {
            UserDiscount::where('id', $userDiscountId)->update([
                'is_used' => true,
                'order_id' => $order->id,
            ]);
        }

        return redirect('pesanan')->with('success', 'Pesanan berhasil dikirim! Kamu dapat ' . $totalPoint . ' poin.')->with('order', $order)->with('refresh', true);;
    }

    public function index()
    {
        $detect = new MobileDetect;
        $isMobile = $detect->isMobile();

        $userId = Auth::id();

        $vouchers = UserDiscount::where('user_id', $userId)
        ->where('is_used', false)
        ->with('reward')
        ->get();

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

        $order = Order::with('userDiscount.reward')
        ->where('user_id', $userId)
        ->latest()
        ->first();

        // View yang dipakai akan tergantung device
        $view = $isMobile ? 'order.pesanan-saya-mobile' : 'order.pesanan-saya';

        return view($view, [
            'order' => $order,
            'pesanan' => $pesanan,
            'status' => $order->status ?? null,
            'currentOrderId' => $order->id ?? null,
            'total' => $total,
            'vouchers' => $vouchers,
        ]);
    }
}