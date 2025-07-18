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
<body class="bg-gray-100 font-sans fade-in min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <a href="/profile" class="flex items-center text-black font-semibold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                BACK
            </a>
            <h1 class="text-2xl font-bold">{{ $order->user->name }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Items -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($order->items as $item)
                <div class="inline-flex items-start bg-white shadow rounded-lg p-3 border w-fit">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-md object-cover mr-3">
                    <div class="text-sm text-gray-700">
                        <p class="font-semibold text-gray-800">{{ $item->menu->name ?? 'Menu' }}</p>
                        <p class="text-green-500 text-xs">+{{ $item->menu->point }} poin</p>
                        <p>Harga Satuan: Rp. {{ number_format($item->items_price, 0, ',', '.') }}</p>
                        <p>Jumlah: {{ $item->quantity }}</p>
                        <p>Subtotal: Rp. {{ number_format($item->items_price * $item->quantity, 0, ',', '.') }}</p>
                        <p>Packaging: {{ $item->packaging }}</p>
                        @if (!empty($item->note))
    <p>Catatan: {{ $item->note }}</p>
@endif

                    </div>
                </div>
                @endforeach

            </div>

            <!-- Right: Info Pesanan -->
            <div class="bg-white shadow rounded-lg p-5 border space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Meja</label>
                    <input type="text" class="w-full border rounded-md p-2" value="{{ $order->table }}" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Catatan tambahan</label>
                    <textarea class="w-full border rounded-md p-2" rows="3" readonly>{{ $order->additional_note }}</textarea>
                </div>

                <h3 class="font-bold text-gray-700 mt-4">Riwayat Pembayaran</h3>
                @foreach ($order->items as $item)
                <div class="flex justify-between text-gray-700 text-sm">
                    <span>{{ $item->menu->name }} x{{ $item->quantity }}</span>
                    <span>Rp. {{ number_format($item->items_price * $item->quantity, 0, ',', '.') }}</span>
                </div>
                @endforeach

                <div class="border-t-2 border-gray-400 my-4"></div>

                <div class="flex justify-between font-semibold text-lg">
                    <span>Total Pembayaran:</span>
                    <span>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
