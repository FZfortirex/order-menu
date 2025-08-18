<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu (Mobile)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br">

  <!-- Tombol Back -->
  <a href="javascript:history.back()" class="mb-4 m-4 inline-flex items-center text-black text-sm font-medium hover:underline">
    ← Kembali
  </a>

  <!-- Card -->
  <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-xl font-bold text-yellow-600 text-center mb-6">Tambah Menu Baru</h1>

    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf

      <!-- Gambar -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-2">Foto Menu</label>
        <div class="relative aspect-square bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
          <img id="previewImage" src="" class="object-cover w-full h-full hidden">
          <span id="noImageText" class="text-gray-400 text-xs">Belum ada gambar</span>
          <button type="button" id="removeImage"
            class="absolute top-2 right-2 bg-white text-red-500 border border-red-300 rounded-full p-1 text-sm hidden">
            &times;
          </button>
        </div>
        <input type="file" name="image" id="image"
          class="mt-2 w-full text-sm text-gray-700 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
      </div>

      <!-- Nama -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-1">Nama Menu</label>
        <input type="text" name="name" placeholder="Contoh: Nasi Goreng"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" required>
          <p class="text-red-500 text-xs mt-1 hidden">Nama menu wajib diisi.</p>
      </div>

      <!-- Harga -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-1">Harga</label>
        <input type="number" name="price" placeholder="Contoh: 15000"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" required>
          <p class="text-red-500 text-xs mt-1 hidden">Harga wajib diisi.</p>
      </div>

      <!-- Diskon -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-1">Harga Diskon (Opsional)</label>
        <input type="number" name="discount_price" placeholder="Contoh: 12000"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400">
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="desc" rows="2" placeholder="Deskripsikan menu di sini..."
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400"></textarea>
          <p class="text-red-500 text-xs mt-1 hidden">Deskripsi wajib diisi.</p>
      </div>

      <!-- Stok -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-1">Stok</label>
        <input type="number" name="stock" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" required>
        <p class="text-red-500 text-xs mt-1 hidden">Stok wajib diisi.</p>
      </div>

      <!-- Poin -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-medium mb-1">Poin</label>
        <input type="number" name="point" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400" required>
        <p class="text-red-500 text-xs mt-1 hidden">Stok wajib diisi.</p>
      </div>

      <!-- Kategori -->
      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-medium mb-1">Kategori</label>
        <select name="category" required
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400">
          <option value="" disabled selected>Pilih kategori</option>
          <option value="Makanan">Makanan</option>
          <option value="Minuman">Minuman</option>
          <option value="Cemilan">Cemilan</option>
          <option value="Paket">Paket</option>
        </select>
        <p class="text-red-500 text-xs mt-1 hidden">Category wajib diisi.</p>
      </div>
      <input type="hidden" name="status" value="sedia">

      <!-- Tombol -->
      <div class="text-center">
        <button type="submit"
          class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
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

    document.addEventListener("DOMContentLoaded", () => {
      form.reset();
      previewImage.classList.add("hidden");
      noImageText.classList.remove("hidden");
      removeImage.classList.add("hidden");
    });

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

    const form = document.querySelector("form");

    function validateField(field) {
      const wrapper = field.parentElement; // div pembungkus field
      const errorMsg = wrapper.querySelector("p.text-red-500");
      let isValid = true;

      if (field.type === 'file') {
        isValid = field.files && field.files.length > 0;
      } else if (field.tagName === 'SELECT') {
        isValid = field.value !== "";
      } else {
        isValid = field.value.trim() !== "";
      }

      if (!isValid) {
        errorMsg && errorMsg.classList.remove("hidden");
        field.classList.add("border-red-500");
        field.classList.remove("border-gray-300");
      } else {
        errorMsg && errorMsg.classList.add("hidden");
        field.classList.remove("border-red-500");
        field.classList.add("border-gray-300");
      }

      return isValid;
    }

    // Live validate saat user input/ubah
    form.querySelectorAll("[required]").forEach(field => {
      const evt = field.type === 'file' ? 'change' : 'input';
      field.addEventListener(evt, () => validateField(field));
    });

    // Cek saat submit
    form.addEventListener("submit", function (e) {
      let valid = true;
      form.querySelectorAll("[required]").forEach(field => {
        if (!validateField(field)) valid = false;
      });
      if (!valid) e.preventDefault();
    });
  </script>
</body>
</html>
