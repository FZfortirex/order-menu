<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Menu Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Container -->
    <div class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">List Menu Orders</h2>

            <!-- Top Controls -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-4">
            <!-- Tombol Recap -->
            <a href="/rekap-penjualan" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                Lihat Rekap Penjualan
            </a>

            <div class="flex gap-4">
                <a href="{{ route('admin.banner') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    Banner Admin
                </a>
                <a href="{{ route('admin.menu') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    Menu Admin
                </a>
                <a href="{{ route('admin.vouchers') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                    Voucher
                </a>
            </div>

        </div>



        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <input type="text" id="search" placeholder="Cari pesanan..." class="w-1/3 p-2 border rounded" oninput="searchOrders()">
            <div class="ml-auto text-gray-700">
                Available tables: <strong class="text-green-600">{{ $availableTables }}/{{ $totalTables }}</strong>
            </div>
        </div>


            <!-- Tombol -->
            <div class="flex justify-start gap-4 mt-4">
                <button onclick="filterOrders('menunggu', this)" id="btn-menunggu" class="filter-btn w-auto border border-yellow-500 text-yellow-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Menunggu</button>
                <button onclick="filterOrders('sedang dibuat', this)" class="filter-btn w-auto border border-yellow-500 text-yellow-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Sedang Dibuat</button>
                <button onclick="filterOrders('sudah dibuat', this)" class="filter-btn w-auto border border-yellow-500 text-yellow-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Sudah Dibuat</button>
                <button onclick="filterOrders('selesai', this)" class="filter-btn w-auto border border-yellow-500 text-yellow-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Selesai</button>
            </div>

            <!-- Order Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6" id="order-list">
                @foreach ($orders as $order)
                <div class="relative bg-white rounded-lg shadow-lg p-5 hover:scale-105 transition-transform order-card cursor-pointer"
                    data-status="{{ strtolower($order->status) }}"
                    data-name="{{ strtolower($order->user->name ?? '-') }}"
                    onclick="window.location.href='/order-detail/{{ $order->id }}'">

                        <!-- Tombol Hapus -->
                        @if (strtolower($order->status) !== 'selesai' && strtolower($order->status) !== 'sudah dibuat' && strtolower($order->status) !== 'sedang dibuat' )
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="absolute top-2 right-2" onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xl font-bold delete-btn">❌</button>
                            </form>
                        @endif

                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-20 aspect-square rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-xl font-bold">
                                👤
                            </div>
                            <div>
                                @php
                                    $isNumeric = isset($order->user->name) && is_numeric($order->user->name);
                                @endphp

                                @if ($isNumeric)
                                    <p class="font-semibold text-gray-800">Nama: Customer ( Meja: {{ $order->user->name }} )</p>
                                    <p class="text-sm text-gray-500">Meja: {{ $order->user->name }}</p>
                                @else
                                    <p class="font-semibold text-gray-800">Nama: {{ $order->user->name ?? '-' }}</p>
                                    <p class="text-sm text-gray-500">Meja: {{ $order->table ?? '-' }}</p>
                                @endif
                                <p class="text-sm text-gray-500">Status: <strong class="text-blue-600">{{ ucfirst($order->status) }}</strong></p>
                                @if (isset($order->total_price))
                                    <p class="text-sm text-gray-500">Harga: <strong class="text-red-600">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials-admin.footer')

    <!-- JavaScript -->
    <script>
    let currentStatus = "menunggu";

    function filterOrders(status, btn) {
        currentStatus = status;

        sessionStorage.setItem('selectedFilter', status);

        const cards = document.querySelectorAll(".order-card");

        cards.forEach(card => {
            const cardStatus = card.getAttribute("data-status");
            card.style.display = (status === 'Menunggu' || cardStatus === status) ? "block" : "none";
        });

        document.querySelectorAll(".filter-btn").forEach(button => {
            button.classList.remove(
                "bg-yellow-500", // tambahkan yellow
                "text-yellow-600" // tambahkan yellow
            );

            if (button.textContent.includes("Menunggu")) {
                button.classList.add("bg-white", "text-yellow-600");
            } else if (button.textContent.includes("Sedang Dibuat")) {
                button.classList.add("bg-white", "text-yellow-600");
            } else if (button.textContent.includes("Sudah Dibuat")) {
                button.classList.add("bg-white", "text-yellow-600");
            } else if (button.textContent.includes("Selesai")) { // tambahkan kondisi untuk selesai
                button.classList.add("bg-white", "text-yellow-600");
            }
        });

        if (btn) {
            if (status === 'menunggu') {
                btn.classList.remove("bg-white", "text-yellow-600");
                btn.classList.add("bg-yellow-500", "text-white");
            } else if (status === 'sedang dibuat') {
                btn.classList.remove("bg-white", "text-yellow-600");
                btn.classList.add("bg-yellow-500", "text-white");
            } else if (status === 'sudah dibuat') {
                btn.classList.remove("bg-white", "text-yellow-600");
                btn.classList.add("bg-yellow-500", "text-white");
            } else if (status === 'selesai') { // tambahkan kondisi untuk selesai
                btn.classList.remove("bg-white", "text-yellow-600");
                btn.classList.add("bg-yellow-500", "text-white");
            }
        }
        searchOrders(); // panggil search agar sinkron setelah filter
    }

    function searchOrders() {
        const inputElement = document.getElementById('search');
        const input = document.getElementById('search').value.toLowerCase();

        sessionStorage.setItem('searchInput', inputElement.value);

        const cards = document.querySelectorAll(".order-card");
        cards.forEach(card => {
            const name = card.getAttribute("data-name");
            const status = card.getAttribute("data-status");

            if (name.includes(input) && status === currentStatus) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }

    // code untuk load otomatis ke filter semua
    document.addEventListener("DOMContentLoaded", function() {
        let reloadInterval;

        function startAutoReload() {
            reloadInterval = setInterval(() => {
                location.reload();
            }, 5000);
            sessionStorage.setItem("autoReload", "true");
        }

        function stopAutoReload() {
            clearInterval(reloadInterval);
            sessionStorage.removeItem("autoReload");
        }

        if (sessionStorage.getItem("autoReload") === "true") {
            startAutoReload();
            } else {
            startAutoReload();
        }

        const searchInput = document.getElementById('search');
        if (searchInput) {
            const savedSearch = sessionStorage.getItem('searchInput') || "";
            searchInput.value = savedSearch;

            searchInput.addEventListener('input', () => {
                searchOrders();
            });
        }


        let savedFilter = sessionStorage.getItem('selectedFilter') || "menunggu";

        const filterButtons = document.querySelectorAll('.filter-btn');
        let btnToClick = null;
        filterButtons.forEach(btn => {
            if (btn.textContent.toLowerCase().includes(savedFilter.toLowerCase())) {
                btnToClick = btn;
            }
        });

        if (btnToClick) {
            filterOrders(savedFilter, btnToClick);
        } else {
            const defaultBtn = document.getElementById("btn-menunggu");
            filterOrders("menunggu", defaultBtn);
        }
        searchOrders();
    });

    if (e.target.classList.contains("status-btn")) {
        const btn = e.target;
        const card = btn.closest(".order-card");
        event.stopPropagation(); // supaya klik tombol nggak ikut trigger card
        const menungguBtns = card.querySelectorAll(".status-btn");

        menungguBtns.forEach((b) => {
            b.classList.remove("bg-blue-600", "bg-red-600", "bg-green-600", "bg-yellow-400", "text-white", "text-black");
            b.classList.add("bg-white");
        });

        if (btn.classList.contains("cancel")) {
            btn.classList.remove("bg-white");
            btn.classList.add("bg-red-600", "text-white");
        } else if (btn.classList.contains("process")) {
            btn.classList.remove("bg-white");
            btn.classList.add("bg-blue-600", "text-white");
            window.location.href = '/listOrder/process';
        } else if (btn.classList.contains("complete")) {
            btn.classList.remove("bg-white");
            btn.classList.add("bg-green-600", "text-white");
            window.location.href = '/listOrder/complete';
        } else if (btn.classList.contains("done")) {
            btn.classList.remove("bg-white");
            btn.classList.add("bg-yellow-400", "text-black");

            const status = card.getAttribute("data-status");
            if (status === 'menunggu') {
                window.location.href = '/listOrder/waiting';
            } else if (status === 'process') {
                window.location.href = '/listOrder/process';
            } else if (status === 'complete') {
                window.location.href = '/listOrder/complete';
            }
        }
    }
    </script>

</body>
</html>