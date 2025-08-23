<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan (Mobile)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-gray-50 font-sans fade-in">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Header -->
    <div class="flex items-center justify-between bg-white shadow px-4 py-3 sticky top-0 z-10">
        <a href="/listOrder" class="flex items-center text-gray-700 font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
        <h1 class="text-lg font-bold text-gray-800">
            @if (is_numeric($order->user->name))
                Meja ({{ $order->user->name }})
            @else
                {{ $order->user->name }}
            @endif
        </h1>
        <div class="w-5"></div>
    </div>

    <!-- Main Content -->
    <div class="p-4 space-y-4">

        <!-- Items -->
        @foreach ($order->items as $item)
        <div class="flex items-start bg-white rounded-lg shadow p-3 space-x-3">
            <img src="{{ $item->image_url }}" alt="{{ $item->menu->name }}" class="w-16 h-16 rounded-md object-cover">
            <div class="flex-1 text-sm">
                <p class="font-semibold text-gray-800">{{ $item->menu->name ?? 'Menu' }}</p>
                <p class="text-green-500">+{{ $item->menu->point }} poin</p>
                <p class="text-gray-700">Rp {{ number_format($item->items_price, 0, ',', '.') }}</p>
                <p class="text-gray-500">Packaging: {{ $item->packaging }}</p>
                <p class="text-gray-500">Catatan: {{ $item->note }}</p>
            </div>
        </div>
        @endforeach

        <!-- Info Pesanan -->
        <div class="bg-white rounded-lg shadow p-4 space-y-3">
            <div>
                <label class="block text-gray-600 font-semibold">Meja</label>
                <input type="text" value="{{ $order->table }}" readonly class="w-full border rounded-md p-2 text-sm">
            </div>

            <h3 class="font-bold text-gray-700">Riwayat Pembayaran</h3>
            @foreach ($order->items as $item)
                <div class="flex justify-between text-sm text-gray-700">
                    <span>{{ $item->menu->name ?? 'Item' }} x{{ $item->quantity }}</span>
                    <span>Rp {{ number_format($item['items_price'] ?? 0) }}</span>
                </div>
            @endforeach

            @if($order->userDiscount)
                <div class="flex justify-between text-green-600 font-semibold text-sm">
                    <span>Voucher Diskon</span>
                    <span>{{ $order->userDiscount->reward->value ?? 0 }}%</span>
                </div>
            @endif

            <div class="border-t my-2"></div>
            <div class="flex justify-between font-semibold text-sm">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>

            <!-- Tombol Status -->
            <div class="mt-3 space-y-2">
                @if($order->status == 'menunggu')
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="sedang dibuat">
                        <button type="submit" class="w-full py-2 rounded-lg border border-yellow-500 text-yellow-600 font-semibold text-sm">
                            Buat
                        </button>
                    </form>
                @elseif($order->status == 'sedang dibuat')
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="sudah dibuat">
                        <button type="submit" class="w-full py-2 rounded-lg border border-green-500 text-green-600 font-semibold text-sm">
                            Siap
                        </button>
                    </form>
                @elseif($order->status == 'sudah dibuat')
                    <form action="{{ route('orders.done', $order->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-2 rounded-lg border border-blue-500 text-blue-600 font-semibold text-sm">
                            Selesai
                        </button>
                    </form>
                @endif

                <p class="text-center text-sm font-semibold text-gray-600">
                    Status:
                    <span class="capitalize">{{ $order->status }}</span>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
