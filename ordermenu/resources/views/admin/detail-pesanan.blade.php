<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi Fade In */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-white font-sans fade-in">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <a href="/listOrder" class="flex items-center text-black font-semibold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                BACK
            </a>
            <h1 class="text-2xl font-bold">
                @if (is_numeric($order->user->name))
                    Meja ( {{ $order->user->name }} )
                @else
                    {{ $order->user->name }}
                @endif
            </h1>
            <div class="w-6"></div> <!-- Placeholder biar judul tetap center -->
        </div>

        <!-- Content: Left & Right -->
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Left: Items -->
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($order->items as $item)
                    <div class="bg-white shadow border rounded-xl overflow-hidden">
                        <!-- Foto -->
                        <img src="{{ $item->image_url }}"
                             alt="{{ $item->menu->name }}"
                             class="w-full h-40 object-cover">

                        <!-- Detail -->
                        <div class="p-3 text-sm space-y-1">
                            <p class="font-semibold text-gray-800 truncate">{{ $item->menu->name ?? 'Menu' }}</p>
                            <p class="text-green-500">+{{ $item->menu->point }} poin</p>
                            <p class="text-gray-700">Harga: Rp. {{ number_format($item->items_price, 0, ',', '.') }}</p>
                            <p class="text-gray-700 text-xs">Packaging: {{ $item->packaging }}</p>
                            <p class="text-gray-700 text-xs truncate">Catatan: {{ $item->note }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right: Info Pesanan -->
            <div class="w-full lg:w-1/3 bg-white shadow rounded-lg p-5 border space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Meja</label>
                    <input type="text" class="w-full border rounded-md p-2" value="{{ $order->table }}" readonly>
                </div>

                <!-- Riwayat Pembayaran -->
                <h3 class="font-bold text-gray-700 mb-2">Riwayat Pembayaran</h3>
                @foreach ($order->items as $item)
                    <div class="flex justify-between text-gray-700 text-sm">
                        <span>{{ $item->menu->name ?? 'Item' }} x{{ $item->quantity }}</span>
                        <span>Rp. {{ number_format($item['items_price'] ?? 0) }}</span>
                    </div>
                @endforeach

                @if($order->userDiscount)
                    <div class="flex justify-between text-green-600 font-semibold mt-2 text-sm">
                        <span>Voucher Diskon</span>
                        <span>Diskon {{ number_format($order->userDiscount->reward->value ?? 0, 0, ',', '.') }} %</span>
                    </div>
                @endif

                <!-- Total -->
                <div class="border-t-2 border-gray-400 my-4"></div>
                <div class="flex justify-between font-semibold">
                    <span>Total Pembayaran:</span>
                    <span>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col gap-2 mt-4">
                    @if($order->status == 'menunggu')
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="sedang dibuat">
                            <button type="submit" class="w-full border bg-white text-yellow-600 border-yellow-500 font-semibold py-2 rounded-lg hover:bg-yellow-50 transition">
                                Buat
                            </button>
                        </form>
                    @elseif($order->status == 'sedang dibuat')
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="sudah dibuat">
                            <button type="submit" class="w-full border bg-white text-yellow-600 border-yellow-500 font-semibold py-2 rounded-lg hover:bg-green-50 transition">
                                Siap
                            </button>
                        </form>
                    @elseif($order->status == 'sudah dibuat')
                        <form action="{{ route('orders.done', $order->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-white text-yellow-600 border border-yellow-500 py-2 rounded-md hover:bg-yellow-100 transition">
                                Selesai
                            </button>
                        </form>
                    @endif

                    <!-- Status -->
                    <div class="text-center mt-2 text-sm font-semibold text-yellow-600">
                        Status:
                        @if($order->status == 'menunggu')
                            <span>Menunggu</span>
                        @elseif($order->status == 'sedang dibuat')
                            <span>Sedang Dibuat</span>
                        @elseif($order->status == 'sudah dibuat')
                            <span>Siap</span>
                        @elseif($order->status == 'selesai')
                            <span>Selesai</span>
                        @else
                            <span>Tidak Diketahui</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
