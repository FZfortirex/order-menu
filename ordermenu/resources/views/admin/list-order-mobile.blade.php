<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Pesanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col text-[14px] leading-tight">

  <!-- Navbar -->
  @include('partials-admin.navbar')

  <!-- Main Content -->
  <main class="flex-grow px-4 py-4">
    <h1 class="text-lg font-bold text-gray-800 text-center mb-4">Daftar Pesanan</h1>

<!-- Top Buttons -->
<div class="flex flex-row justify-between gap-4 mb-4 px-4">
  <a href="/rekap-penjualan" class="bg-yellow-500 hover:bg-yellow-400 text-white py-2 px-4 rounded shadow text-sm font-semibold w-[140px] text-center">
    Rekap Penjualan
  </a>
  <a href="{{ route('admin.menu') }}" class="bg-yellow-500 hover:bg-yellow-400 text-white py-2 px-4 rounded shadow text-sm font-semibold w-[140px] text-center">
    Menu Admin
  </a>
  <a href="{{ route('admin.banner') }}" class="bg-yellow-500 hover:bg-yellow-400 text-white py-2 px-4 rounded shadow text-sm font-semibold w-[140px] text-center">
                    Banner Admin
                </a>
</div>



    <!-- Search + Table Info -->
    <div class="flex flex-col gap-2 mb-4">
      <input id="search" oninput="searchOrders()" type="text" placeholder="Cari pesanan..."
        class="w-full px-3 py-2 rounded border border-gray-300 focus:outline-none text-sm">
      <p class="text-xs text-gray-600 text-center">Meja Tersedia:
        <span class="text-green-600 font-semibold">{{ $availableTables }}/{{ $totalTables }}</span>
      </p>
    </div>

    <!-- Filter -->
    <div class="flex overflow-x-auto gap-2 mb-4 scrollbar-hide text-xs">
      <button onclick="filterOrders('menunggu', this)" id="btn-menunggu"
        class="filter-btn px-3 py-1.5 rounded-full bg-yellow-500 text-white font-medium whitespace-nowrap">
        Menunggu
      </button>
      <button onclick="filterOrders('sedang dibuat', this)"
        class="filter-btn px-3 py-1.5 rounded-full border border-yellow-500 text-yellow-600 font-medium whitespace-nowrap">
        Sedang Dibuat
      </button>
      <button onclick="filterOrders('sudah dibuat', this)"
        class="filter-btn px-3 py-1.5 rounded-full border border-yellow-500 text-yellow-600 font-medium whitespace-nowrap">
        Sudah Dibuat
      </button>
      <button onclick="filterOrders('selesai', this)"
        class="filter-btn px-3 py-1.5 rounded-full border border-yellow-500 text-yellow-600 font-medium whitespace-nowrap">
        Selesai
      </button>
    </div>

    <!-- Orders -->
    <div id="order-list" class="flex flex-col gap-3">
      @foreach ($orders as $order)
      <div onclick="window.location.href='/order-detail/{{ $order->id }}'"
        class="relative order-card bg-white p-3 rounded-xl shadow hover:shadow-md transition cursor-pointer"
        data-status="{{ strtolower($order->status) }}"
        data-name="{{ strtolower($order->user->name ?? '-') }}">

        <!-- Hapus -->
        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="absolute top-2 right-2" onclick="event.stopPropagation();">
          @csrf
          @method('DELETE')
          <button type="submit" class="text-red-500 hover:text-red-700 text-lg leading-none">✕</button>
        </form>

        <div class="flex items-start gap-3">
          <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-xl">👤</div>
          <div class="flex-1 text-xs">
            @php $isNumeric = isset($order->user->name) && is_numeric($order->user->name); @endphp
            <p class="font-semibold text-gray-800">
              Nama: {{ $isNumeric ? 'Customer' : ($order->user->name ?? '-') }}
            </p>
            <p class="text-gray-500">Meja: {{ $isNumeric ? $order->user->name : ($order->table ?? '-') }}</p>
            <p class="text-gray-500">Status: <span class="text-blue-600 font-semibold">{{ ucfirst($order->status) }}</span></p>
            @if(isset($order->total_price))
            <p class="text-gray-500">Harga: <span class="text-red-600 font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </main>

  <!-- Footer -->
  @include('partials-admin.footer')

  <!-- Scripts -->
  <script>
    let currentStatus = "menunggu";

    function filterOrders(status, btn) {
      currentStatus = status;
      const cards = document.querySelectorAll(".order-card");

      cards.forEach(card => {
        const cardStatus = card.getAttribute("data-status");
        card.style.display = (cardStatus === status) ? "block" : "none";
      });

      document.querySelectorAll(".filter-btn").forEach(button => {
        button.classList.remove("bg-yellow-500", "text-white");
        button.classList.add("bg-white", "text-yellow-600", "border", "border-yellow-500");
      });

      btn.classList.remove("bg-white", "text-yellow-600", "border");
      btn.classList.add("bg-yellow-500", "text-white");
    }

    function searchOrders() {
      const input = document.getElementById('search').value.toLowerCase();
      const cards = document.querySelectorAll(".order-card");
      cards.forEach(card => {
        const name = card.getAttribute("data-name");
        const status = card.getAttribute("data-status");
        const isVisible = name.includes(input) && status === currentStatus;
        card.style.display = isVisible ? "block" : "none";
      });
    }

    document.addEventListener("DOMContentLoaded", () => {
      const defaultBtn = document.getElementById("btn-menunggu");
      filterOrders("menunggu", defaultBtn);
    });
  </script>
</body>
</html>
