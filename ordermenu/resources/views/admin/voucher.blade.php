<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="from-red-900 to-indigo-200 min-h-screen flex items-center justify-center px-4 py-8 font-sans relative">


  <!-- Tombol Back -->
  <a href="javascript:history.back()"
     class="absolute top-4 left-4 flex items-center space-x-2 text-gray-700 hover:text-gray-900 font-medium text-lg px-3 py-2 rounded-lg hover:bg-gray-100 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
    </svg>
    <span>Back</span>
  </a>

  <!-- Card -->
  <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl p-8 transition-all duration-300">
    <h1 class="text-3xl font-extrabold text-yellow-600 mb-8 text-center">Tambah Menu Baru</h1>

    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf

      <div class="flex flex-col md:flex-row gap-6">

        <!-- Form Input -->
        <div class="w-full md:w-2/3 space-y-4">

          <div>
            <label class="block text-gray-700 font-medium mb-1">Nama</label>
            <input type="text" name="name" placeholder="Contoh: Diskon 20%"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required>
              <p class="text-red-500 text-xs mt-1 hidden">Nama wajib diisi.</p>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Point Penukaran</label>
            <input type="number" name="point_required" placeholder="Contoh: 20"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required>
              <p class="text-red-500 text-xs mt-1 hidden">Point Penukaran wajib diisi.</p>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Type</label>
            <select name="type" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition">
              <option value="" disabled selected>Pilih kategori</option>
              <option value="discount">Discount</option>
            </select>
            <p class="text-red-500 text-xs mt-1 hidden">Wajib diisi.</p>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Diskon berapa persen</label>
            <input type="number" name="value" placeholder="20"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required min="0">
              <p class="text-red-500 text-xs mt-1 hidden">Wajib diisi.</p>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Stok</label>
            <input type="number" name="stock" placeholder="Jumlah stok"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required min="0">
              <p class="text-red-500 text-xs mt-1 hidden">Stok wajib diisi.</p>
          </div>
        </div>
      </div>
      <input type="hidden" name="status" value="sedia">

      <!-- Tombol Submit -->
      <div class="flex justify-center mt-8">
        <button type="submit"
          class="bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-yellow-700 hover:shadow-lg transition-all duration-300">
          Simpan
        </button>
      </div>
    </form>
  </div>

</body>
</html>
