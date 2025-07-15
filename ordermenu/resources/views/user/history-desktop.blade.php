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
    @include('partials-admin.navbar')

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @php
        // Dummy data
        $items = collect([
            (object)[
                'menu' => (object)[
                    'name' => 'Nasi Goreng Special',
                    'point' => 20
                ],
                'image_url' => 'https://via.placeholder.com/80',
                'items_price' => 25000,
                'packaging' => 'Box',
                'note' => 'Tidak pedas',
                'quantity' => 2
            ],
            (object)[
                'menu' => (object)[
                    'name' => 'Ayam Bakar',
                    'point' => 15
                ],
                'image_url' => 'https://via.placeholder.com/80',
                'items_price' => 30000,
                'packaging' => 'Plastik',
                'note' => 'Paha atas',
                'quantity' => 1
            ],
        ]);

        $order = (object)[
            'user' => (object)[
                'name' => 'John Doe'
            ],
            'table' => 'A12',
            'additional_note' => 'Tolong cepat ya, saya lapar.',
            'items' => $items,
            'total_price' => $items->sum(function($item) {
                return $item->items_price * $item->quantity;
            })
        ];
        @endphp

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
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($order->items as $item)
                <div class="flex bg-white shadow rounded-lg p-4 border">
                    <img src="{{ $item->image_url }}" alt="{{ $item->menu->name }}" class="w-20 h-20 rounded-md object-cover mr-4">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->menu->name ?? 'Menu' }}</p>
                        <p class="text-green-500 text-sm">+{{ $item->menu->point }} poin</p>
                        <p class="text-gray-700 text-sm">Harga Satuan: Rp. {{ number_format($item->items_price, 0, ',', '.') }}</p>
                        <p class="text-gray-700 text-sm">Jumlah: {{ $item->quantity }}</p>
                        <p class="text-gray-700 text-sm">Subtotal: Rp. {{ number_format($item->items_price * $item->quantity, 0, ',', '.') }}</p>
                        <p class="text-gray-700 text-sm">Packaging: {{ $item->packaging }}</p>
                        <p class="text-gray-700 text-sm">Catatan: {{ $item->note }}</p>
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

    <!-- Floating Chat Button -->
    <button id="toggleChat" class="fixed bottom-6 left-6 bg-green-500 hover:bg-green-600 text-white p-3 rounded-full shadow-lg z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 3.866-3.582 7-8 7H5l-4 4V5c0-1.104.896-2 2-2h14c1.104 0 2 .896 2 2v7z" />
        </svg>
    </button>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
