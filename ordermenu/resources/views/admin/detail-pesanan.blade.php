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

        <div class="flex items-center justify-between mb-6">
            <a href="/listOrder" class="flex items-center text-black font-semibold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                BACK
            </a>
            <h1 class="text-2xl font-bold">{{ $order->user->name }}</h1>
            <div class="w-6"></div> <!-- Placeholder biar posisi center -->
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Items -->
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($order->items as $item)
                <div class="flex items-center bg-white shadow rounded-lg p-3 border">
                    <img src="{{ $item->image_url }}" alt="{{ $item->menu->name }}" class="w-20 h-20 rounded-md object-cover mr-4">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->menu->name ?? 'Menu' }}</p>
                        <p class="text-green-500 text-sm">+{{ $item->menu->point }} poin</p>
                        <p class="text-gray-700 text-sm">Harga: Rp. {{ number_format($item->items_price, 0, ',', '.') }}</p>
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

    <!-- Garis pemisah -->
        <h3 class="font-bold text-gray-700 mb-2">Riwayat Pembayaran</h3>
        <div class="flex justify-between text-gray-700">
            <span>{{ $order->items->first()->menu->name ?? 'Item' }} x{{ $order->items->sum('quantity') }}</span>
            <span>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
        <!-- Garis tebal -->
        <div class="border-t-2 border-gray-400 my-4"></div>
        <div class="flex justify-between font-semibold mt-2">
            <span>Total Pembayaran:</span>
            <span>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <!-- Tombol -->
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex justify-between gap-2 mt-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="sedang dibuat">
            <button type="submit" class="flex-1 
                {{ $order->status == 'sedang dibuat' ? 'border-4 border-blue-400 bg-blue-400 text-white' : 'border border-blue-400 text-blue-500' }} 
                font-semibold py-2 rounded-lg hover:bg-blue-50 transition">
                Buat
            </button>
        </form>

        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex-1">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="sudah dibuat">
            <button type="submit" class="w-full 
                {{ $order->status == 'sudah dibuat' ? 'border-4 border-green-400 bg-green-400 text-white' : 'border border-green-400 text-green-500' }} 
                font-semibold py-2 rounded-lg hover:bg-green-50 transition">
                Siap
            </button>
        </form>

        <form action="{{ route('orders.done', $order->id) }}" method="POST" class="flex-1">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-white text-yellow-600 border border-yellow-500 py-2 rounded-md hover:bg-yellow-100 transition">
                Selesai
            </button>
        </form>
</div>

            </div>
        </div>

        <!-- Floating Chat Button -->
<button id="toggleChat" class="fixed bottom-6 left-6 bg-green-500 hover:bg-green-600 text-white p-3 rounded-full shadow-lg z-50">
    <!-- Icon Chat -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 3.866-3.582 7-8 7H5l-4 4V5c0-1.104.896-2 2-2h14c1.104 0 2 .896 2 2v7z" />
    </svg>
</button>

<!-- Chat Box (Hidden by default) -->
<div id="chatBox" class="fixed bottom-6 left-6 w-72 bg-white border rounded-lg shadow-lg overflow-hidden hidden z-50">
    <div class="flex justify-between items-center bg-gray-100 p-2">
        <span class="font-semibold">Message</span>
        <button id="closeChat" class="text-gray-600 hover:text-red-500">&times;</button>
    </div>
    <div class="p-3 h-40 overflow-y-auto">
        <div class="flex items-center mb-2">
            <div class="w-6 h-6 bg-gray-300 rounded-full mr-2"></div>
            <div class="bg-gray-100 p-2 rounded-md text-sm">Mohon ditunggu ya</div>
        </div>
    </div>
    <div class="border-t flex p-2 items-center">
        <input type="text" placeholder="Type here" class="flex-1 p-1 text-sm border-none focus:ring-0">
        <button class="ml-2 bg-green-400 hover:bg-green-300 text-white p-2 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </button>
    </div>
</div>


    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script>
    const toggleChat = document.getElementById('toggleChat');
    const chatBox = document.getElementById('chatBox');
    const closeChat = document.getElementById('closeChat');

    toggleChat.addEventListener('click', () => {
        chatBox.classList.remove('hidden');
        toggleChat.classList.add('hidden');
    });

    closeChat.addEventListener('click', () => {
        chatBox.classList.add('hidden');
        toggleChat.classList.remove('hidden');
    });
</script>

</body>
</html>
