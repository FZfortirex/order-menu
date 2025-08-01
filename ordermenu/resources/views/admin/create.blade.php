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

    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="flex flex-col md:flex-row gap-6">

        <!-- Gambar Preview -->
        <div class="w-full md:w-1/3">
          <label class="block text-gray-700 font-medium mb-2">Foto Menu</label>
          <div class="relative w-full aspect-square bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
            <img id="previewImage" src="" class="object-cover w-full h-full hidden">
            <span id="noImageText" class="text-gray-400 text-sm">Belum ada gambar</span>
            <button type="button" id="removeImage"
              class="absolute top-2 right-2 bg-white text-red-500 border border-red-300 rounded-full p-1 hover:bg-red-100 transition hidden">
              &times;
            </button>
          </div>

          <div class="mt-3">
            <input type="file" name="image" id="image"
              class="w-full text-sm text-gray-700 file:mr-3 file:py-1 file:px-3
              file:rounded-md file:border-0 file:text-sm file:font-semibold
              file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" required>
          </div>
        </div>

        <!-- Form Input -->
        <div class="w-full md:w-2/3 space-y-4">

          <div>
            <label class="block text-gray-700 font-medium mb-1">Nama Menu</label>
            <input type="text" name="name" placeholder="Contoh: Nasi Goreng"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Harga</label>
            <input type="number" name="price" placeholder="Contoh: 15000"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required>
          </div>

          <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-1">Harga Diskon (Opsional)</label>
        <input type="number" name="discount_price" placeholder="Contoh: 12000"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
          min="0">
      </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
            <textarea name="desc" rows="3" placeholder="Deskripsikan menu di sini..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition"></textarea>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Stok</label>
            <input type="number" name="stock" placeholder="Jumlah stok"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required min="0">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Poin</label>
            <input type="number" name="point" placeholder="Masukkan poin"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition" required min="0">
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1">Kategori</label>
            <select name="category" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition">
              <option value="" disabled selected>Pilih kategori</option>
              <option value="Makanan">Makanan</option>
              <option value="Minuman">Minuman</option>
              <option value="Cemilan">Cemilan</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tombol Submit -->
      <div class="flex justify-center mt-8">
        <button type="submit"
          class="bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-yellow-700 hover:shadow-lg transition-all duration-300">
          Simpan
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
