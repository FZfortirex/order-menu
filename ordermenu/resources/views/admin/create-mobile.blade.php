<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu (Mobile)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8 font-sans relative">

  <!-- Tombol Back -->
  <a href="javascript:history.back()"
     class="absolute top-4 left-4 flex items-center space-x-2 text-gray-700 hover:text-gray-900 font-medium text-sm px-3 py-2 rounded-lg hover:bg-gray-200 transition">
    ← Kembali
  </a>

  <!-- Card -->
  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">
    <h1 class="text-2xl font-extrabold text-yellow-600 mb-6 text-center">Tambah Menu Baru</h1>

    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Gambar Preview -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Foto Menu</label>
        <div class="relative w-full aspect-square bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
          <img id="previewImage" src="" class="object-cover w-full h-full hidden">
          <span id="noImageText" class="text-gray-400 text-xs">Belum ada gambar</span>
          <button type="button" id="removeImage"
            class="absolute top-2 right-2 bg-white text-red-500 border border-red-300 rounded-full p-1 hover:bg-red-100 transition hidden">
            &times;
          </button>
        </div>
        <input type="file" name="image" id="image"
          class="mt-2 w-full text-sm text-gray-700 file:mr-2 file:py-1 file:px-3
          file:rounded-md file:border-0 file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100"
          required>
      </div>

      <!-- Input Nama -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Nama Menu</label>
        <input type="text" name="name" placeholder="Contoh: Nasi Goreng"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" required>
      </div>

      <!-- Harga -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Harga</label>
        <input type="number" name="price" placeholder="Contoh: 15000"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" required min="0">
      </div>

      <!-- Diskon -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Harga Diskon (Opsional)</label>
        <input type="number" name="discount_price" placeholder="Contoh: 12000"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" min="0">
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
        <textarea name="desc" rows="2" placeholder="Deskripsikan menu..."
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400"></textarea>
      </div>

      <!-- Stok -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Stok</label>
        <input type="number" name="stock"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400"
          required min="0">
      </div>

      <!-- Poin -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Poin</label>
        <input type="number" name="point"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400"
          required min="0">
      </div>

      <!-- Kategori -->
      <div class="mb-6">
        <label class="block text-gray-700 font-medium mb-1">Kategori</label>
        <select name="category" required
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400">
          <option value="" disabled selected>Pilih kategori</option>
          <option value="Makanan">Makanan</option>
          <option value="Minuman">Minuman</option>
          <option value="Cemilan">Cemilan</option>
        </select>
      </div>

      <!-- Tombol -->
      <div class="text-center">
        <button type="submit"
          class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow transition">
          Simpan Menu
        </button>
      </div>
    </form>
  </div>

  <!-- Script Preview -->
  <script>
    const fileInput = document.getElementById('image');
    const previewImage = document.getElementById('previewImage');
    const noImageText = document.getElementById('noImageText');
    const removeImage = document.getElementById('removeImage');

    fileInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        previewImage.src = URL.createObjectURL(file);
        previewImage.classList.remove('hidden');
        noImageText.classList.add('hidden');
        removeImage.classList.remove('hidden');
      }
    });

    removeImage.addEventListener('click', function () {
      previewImage.classList.add('hidden');
      noImageText.classList.remove('hidden');
      fileInput.value = '';
      previewImage.src = '';
      removeImage.classList.add('hidden');
    });
  </script>

</body>
</html>
