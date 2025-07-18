<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>List Menu Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
  @include('partials-admin.navbar')

  <!-- Container -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Judul -->
    <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">List Menu Orders</h2>

   <!-- Grafik Mingguan -->
   <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
      <h3 class="text-xl font-semibold text-gray-700 mb-4">Grafik Penjualan Mingguan</h3>
      <canvas id="salesChart" height="50"></canvas>
    </div>


    <!-- Top Controls -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
      <input type="text" placeholder="Cari pesanan..." class="px-4 py-2 border rounded-md w-64 shadow-sm focus:ring focus:ring-red-300">
      <div class="ml-auto text-gray-700">
        Available tables: <strong class="text-yellow-600">{{ $availableTables }}/{{ $totalTables }}</strong>
      </div>
    </div>

    <!-- Tombol Filter -->
    <div class="flex justify-start gap-4 mt-4">
      <button onclick="filterOrders('menunggu', this)" id="btn-menunggu" class="filter-btn w-auto border border-yellow-500 bg-white font-semibold py-2 px-4 rounded-lg transition">Menunggu</button>
      <button onclick="filterOrders('sedang dibuat', this)" class="filter-btn w-auto border border-yellow-500 text-blue-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Sedang Dibuat</button>
      <button onclick="filterOrders('sudah dibuat', this)" class="filter-btn w-auto border border-yellow-500 text-green-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Sudah Dibuat</button>
      <button onclick="filterOrders('selesai', this)" class="filter-btn w-auto border border-yellow-500 text-yellow-600 bg-white font-semibold py-2 px-4 rounded-lg transition">Selesai</button>
    </div>

    <!-- Order Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6" id="order-list">
      @foreach ($orders as $order)
      <div class="relative bg-white rounded-lg shadow-lg p-5 hover:scale-105 transition-transform order-card cursor-pointer"
           data-status="{{ strtolower($order->status) }}"
           onclick="window.location.href='/order-detail/{{ $order->id }}'">

        <!-- Tombol Hapus -->
        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="absolute top-2 right-2" onclick="event.stopPropagation();">
          @csrf
          @method('DELETE')
          <button type="submit" class="text-red-500 hover:text-red-700 text-xl font-bold delete-btn">❌</button>
        </form>

        <div class="flex items-center gap-4 mb-4">
          <div class="w-14 h-14 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-xl font-bold">
            👤
          </div>
          <div>
            <p class="font-semibold text-gray-800">Antrian: {{ $loop->iteration }}</p>
            <p class="text-sm text-gray-500">Meja: {{ $order->table ?? '-' }}</p>
            <p class="text-sm text-gray-500">Status: <strong class="text-blue-600">{{ ucfirst($order->status) }}</strong></p>
            @if (isset($order->total_price))
              <p class="text-sm text-gray-500">Harga: <strong class="text-red-600">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
            @endif
            @if (isset($order->additional_note))
              <p class="text-sm text-gray-500">Catatan: {{ $order->additional_note }}</p>
            @endif
          </div>
        </div>

        <div class="flex flex-wrap gap-2 justify-between mt-4">
          <button class="status-btn done flex-1 bg-white text-yellow-600 border border-yellow-500 px-3 py-1 rounded-md hover:bg-yellow-100 transition">Done</button>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Tombol Chat -->
  <a href="/chat" class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-full shadow-lg border border-black">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.857L3 20l1.543-3.86A7.96 7.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
  </a>

  <!-- Footer -->
  @include('partials-admin.footer')

  <!-- JavaScript -->
  <script>
    function filterOrders(status, btn) {
      const cards = document.querySelectorAll(".order-card");

      cards.forEach(card => {
        const cardStatus = card.getAttribute("data-status");
        card.style.display = (status === 'menunggu' || cardStatus === status) ? "block" : "none";
      });

      document.querySelectorAll(".filter-btn").forEach(button => {
        button.classList.remove(
          "bg-black", "bg-blue-500", "bg-green-500", "bg-yellow-500",
          "text-white", "text-black", "text-blue-600", "text-green-600", "text-yellow-600"
        );

        if (button.textContent.includes("Menunggu")) {
          button.classList.add("bg-white", "text-yellow-600");
        } else if (button.textContent.includes("Sedang Dibuat")) {
          button.classList.add("bg-white", "text-yellow-600");
        } else if (button.textContent.includes("Sudah Dibuat")) {
          button.classList.add("bg-white", "text-yellow-600");
        } else if (button.textContent.includes("Selesai")) {
          button.classList.add("bg-white", "text-yellow-600", "border", "border-yellow-500");
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
        } else if (status === 'selesai') {
          btn.classList.remove("bg-white", "text-yellow-600");
          btn.classList.add("bg-yellow-500", "text-white");
        }
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      const defaultBtn = document.getElementById("btn-menunggu");
      filterOrders("menunggu", defaultBtn);
    });

    // Chart.js grafik mingguan
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
    datasets: [{
      label: 'Total Penjualan (IDR)',
      data: [500000, 700000, 600000, 800000, 550000, 900000, 750000],
      backgroundColor: 'rgba(251, 191, 36, 0.7)', // kuning
      borderColor: 'rgba(251, 191, 36, 1)',      // kuning solid
      borderWidth: 1,
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: true, // Biar proporsional dan tidak menjulur tinggi
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function(value) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
          }
        }
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: function(context) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
          }
        }
      },
      legend: {
        display: true
      }
    }
  }
});

  </script>
</body>
</html>