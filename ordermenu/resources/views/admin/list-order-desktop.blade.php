<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Menu Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">List Menu Orders</h2>

    <!-- Top Controls -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <input type="text" placeholder="Cari pesanan..." class="px-4 py-2 border rounded-md w-64 shadow-sm focus:ring focus:ring-red-300">
        <div class="ml-auto text-gray-700">
            Available tables: <strong class="text-green-600">{{ $availableTables }}/{{ $totalTables }}</strong>
        </div>
    </div>


        <!-- Order Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="order-list">
            @foreach ($orders as $order)
                <div class="relative bg-white rounded-lg shadow-lg p-5 hover:scale-105 transition-transform order-card">
                    <!-- Tombol Hapus -->
                    <button class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl font-bold delete-btn">❌</button>

                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-xl font-bold">
                            👤
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Nama : {{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">Meja: {{ $order->table ?? '-' }}</p> 
                            <p class="text-sm text-gray-500">Harga: <strong class="text-red-600">{{ number_format($order->total_price, 0, ',', '.') }} Rp</strong></p>
                            <p class="text-sm text-gray-500">Catatan : {{ $order->additional_note }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 justify-between mt-4">
                        <button class="status-btn cancel flex-1 bg-white text-red-600 border border-red-500 px-3 py-1 rounded-md hover:bg-red-100 transition">Cancel</button>
                        <button class="status-btn process flex-1 bg-white text-blue-600 border border-blue-500 px-3 py-1 rounded-md hover:bg-blue-100 transition">Process</button>
                        <button class="status-btn complete flex-1 bg-white text-green-600 border border-green-500 px-3 py-1 rounded-md hover:bg-green-100 transition">Complete</button>
                        <button class="status-btn done flex-1 bg-white text-yellow-600 border border-yellow-500 px-3 py-1 rounded-md hover:bg-yellow-100 transition">Done</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

   <!-- Tombol Chat -->
<a href="/chat" class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-full shadow-lg border border-black">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.857L3 20l1.543-3.86A7.96 7.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
  </svg>
</a>


    <!-- Footer -->
    @include('partials.footer')

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const orderList = document.getElementById("order-list");

            // Status Button Logic
            orderList.addEventListener("click", function (e) {
                if (e.target.classList.contains("status-btn")) {
                    const btn = e.target;
                    const card = btn.closest(".order-card");
                    const allBtns = card.querySelectorAll(".status-btn");

                    allBtns.forEach((b) => {
                        b.classList.remove("bg-blue-600", "bg-red-600", "bg-green-600", "bg-yellow-400", "text-white", "text-black");
                        b.classList.add("bg-white");
                    });

                    if (btn.classList.contains("cancel")) {
                        btn.classList.remove("bg-white");
                        btn.classList.add("bg-red-600", "text-white");
                    } else if (btn.classList.contains("process")) {
                        btn.classList.remove("bg-white");
                        btn.classList.add("bg-blue-600", "text-white");
                    } else if (btn.classList.contains("complete")) {
                        btn.classList.remove("bg-white");
                        btn.classList.add("bg-green-600", "text-white");
                    } else if (btn.classList.contains("done")) {
                        btn.classList.remove("bg-white");
                        btn.classList.add("bg-yellow-400", "text-black");
                    }
                }

                // Delete Button Logic
                if (e.target.classList.contains("delete-btn")) {
                    const card = e.target.closest(".order-card");
                    card.remove();
                }
            });
        });
    </script>

</body>
</html>
