<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tukar Poin - Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-black">
  <!-- Navbar -->
@include('partials.navbar')

  <!-- Header -->
  <div class="flex items-center justify-between px-6 mt-6">
    <div class="text-lg font-semibold flex items-center space-x-2">
      <span class="text-2xl">⬅️</span>
      <span>BACK</span>
    </div>
    <h1 class="text-xl font-bold">Tukar Poin</h1>
    <div></div>
  </div>

  <!-- Total Poin Kamu -->
  <div class="border rounded-lg shadow-md mx-6 mt-6 flex">
    <div class="bg-maroon-800 text-white p-6 text-4xl">
      💲
    </div>
    <div class="p-6 flex-1">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-xl font-semibold">Total Poin Kamu</h2>
          <p class="text-2xl font-bold mt-1">20 poin</p>
          <div class="flex space-x-6 mt-2 text-sm">
            <div>Poin Dasar<br><span class="font-semibold">10 poin</span></div>
            <div class="border-l border-gray-400 pl-4">Poin Bonus<br><span class="font-semibold">10 poin</span></div>
          </div>
        </div>
        <a href="#" class="text-red-700 text-sm font-semibold">Riwayat &gt;</a>
      </div>
    </div>
  </div>

  <!-- Filter Tabs -->
  <div class="flex space-x-4 px-6 mt-6">
    <button class="bg-yellow-400 text-black px-4 py-2 rounded-md flex items-center space-x-2">
      <span class="text-xl">☰</span><span>Semua</span>
    </button>
    <button class="border border-gray-400 px-4 py-2 rounded-md flex items-center space-x-2">
      <span class="text-xl">⚙️</span><span>Diskcn</span>
    </button>
  </div>

  <!-- Voucher Card -->
  <div class="px-6 mt-8">
    <div class="w-40 border rounded-lg shadow-md p-4">
      <img src="https://via.placeholder.com/100x100.png?text=10%25+OFF" alt="Diskon 10%" class="mx-auto mb-2">
      <p class="text-sm text-center mb-2">Diskon 10%<br><span class="text-xs">50 poin</span></p>
      <button class="bg-yellow-400 text-black px-4 py-1 rounded w-full text-sm">Tukar</button>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-black text-white mt-12 py-8">
    <div class="text-center text-yellow-400 text-lg font-bold">Kampoeng Sawah</div>
    <div class="flex justify-center space-x-8 mt-4 text-sm">
      <a href="#">Home</a>
      <a href="#">Galeri</a>
      <a href="#">Kontak</a>
      <a href="#">Opsi</a>
    </div>
    <div class="text-center text-xs mt-4">&copy; 2025 kampoengsawahsegaran</div>
  </footer>
</body>
</html>
