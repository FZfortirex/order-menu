<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tukar Poin - Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-maroon { background-color: #601B16; }
  </style>
</head>
<body class="bg-white text-black font-sans">

  <!-- Navbar -->
  @include('partials.navbar')

  <!-- Header -->
  <header class="flex justify-between items-center px-6 py-4 border-b shadow-sm bg-gray-50">
    <a href="{{ url('/profile') }}" class="text-maroon text-sm font-semibold flex items-center hover:underline">
      &#x2190; <span class="ml-1">Back</span>
    </a>
    <h1 class="text-lg sm:text-xl font-bold text-gray-800">Tukar Poin</h1>
    <div class="w-10"></div>
  </header>

  <!-- Total Poin -->
  <section class="mx-6 mt-6 border rounded-lg shadow-md overflow-hidden flex flex-col sm:flex-row">
    <div class="bg-maroon text-white p-6 flex items-center justify-center text-4xl font-bold sm:w-32">$</div>
    <div class="p-6 flex-1">
      <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
          <h2 class="text-lg font-semibold">Total Poin Kamu</h2>
          <p class="text-2xl font-bold mt-1">{{ $user->my_points }} Poin</p>
          <div class="flex space-x-6 mt-2 text-sm text-gray-600">
            <div>Poin Dasar<br><span class="font-semibold text-black">10 poin</span></div>
            <div class="border-l pl-4 border-gray-400">Poin Bonus<br><span class="font-semibold text-black">10 poin</span></div>
          </div>
        </div>
        <a href="#" class="text-red-600 text-sm font-medium hover:underline mt-2">Riwayat &gt;</a>
      </div>
    </div>
  </section>

  <!-- Filter Tabs -->
  <div class="flex flex-wrap gap-4 px-6 mt-6">
    <button class="bg-yellow-400 text-black px-4 py-2 rounded-md flex items-center space-x-2 font-medium shadow hover:brightness-95">
      <span class="text-xl">☰</span><span>Semua</span>
    </button>
    <button class="border border-gray-400 px-4 py-2 rounded-md flex items-center space-x-2 font-medium hover:bg-gray-100">
      <span class="text-xl">⚙️</span><span>Diskon</span>
    </button>
  </div>

  <!-- Voucher List -->
  <section class="px-6 mt-8 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <!-- Contoh 1 Voucher -->
    <div class="border rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col items-center">
      <img src="https://via.placeholder.com/100x100.png?text=10%25+OFF" alt="Diskon 10%" class="mb-3 rounded">
      <p class="text-center text-sm font-medium mb-1">Diskon 10%</p>
      <span class="text-xs text-gray-500 mb-3">50 poin</span>
      <button class="bg-yellow-400 text-black px-4 py-1 rounded w-full text-sm font-semibold hover:brightness-95">Tukar</button>
    </div>

    <!-- Tambahkan kartu voucher lain jika perlu -->
  </section>

  <!-- Footer -->
  @include('partials.footer')


</body>
</html>
