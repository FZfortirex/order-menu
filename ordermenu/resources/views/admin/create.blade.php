<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="from-red-900 to-indigo-200 min-h-screen flex items-center justify-center px-4 py-8 font-sans">

  <div class="w-full max-w-xl bg-white rounded-2xl shadow-xl p-8 transition-all duration-300">
    <h1 class="text-3xl font-extrabold text-yellow-600 mb-6 text-center">Tambah Menu Baru</h1>
    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Nama Menu</label>
        <input type="text" name="name" placeholder="Contoh: Nasi Goreng"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Harga</label>
        <input type="number" name="price" placeholder="Contoh: 15000"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Harga Diskon (Opsional)</label>
        <input type="number" name="discount_price" placeholder="Contoh: 12000"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
          min="0">
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
        <textarea name="desc" rows="3" placeholder="Deskripsikan menu di sini..."
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"></textarea>
      </div>

      <div class="mb-4">
  <label for="stock" class="block text-gray-700 font-medium mb-1">Stok</label>
  <input type="number" name="stock" id="stock" placeholder="Jumlah stok"
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
    required min="0">
</div>

<div class="mb-4">
  <label for="point" class="block text-gray-700 font-medium mb-1">Poin</label>
  <input type="number" name="point" id="point" placeholder="Masukkan poin"
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
    required min="0" value="{{ old('point') }}">
</div>


      <div class="mb-4">
  <label for="category" class="block text-gray-700 font-medium mb-1">Kategori</label>
  <select name="category" id="category" required
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
    <option value="" disabled selected>Pilih kategori</option>
    <option value="Makanan">Makanan</option>
    <option value="Minuman">Minuman</option>
    <option value="Cemilan">Cemilan</option>
  </select>
</div>


<div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Foto</label>
        <input type="file" name="image"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" required>
    </div>

      <div class="flex justify-end">
        <button type="submit"
          class="bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-indigo-700 hover:shadow-lg transition-all duration-300">
          Simpan
        </button>
      </div>
    </form>
  </div>

</body>
</html>