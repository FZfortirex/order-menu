<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Container -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Edit Menu</h2>

        <!-- Form Edit Menu -->
        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row gap-6">

                <!-- Preview Gambar -->
                <div class="w-full md:w-1/3">
                    <label class="block text-gray-700 font-semibold mb-2">Gambar Menu</label>
                    <div class="relative w-full aspect-square bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                        <img id="previewImage"
                            src="{{ asset('images/' . $menu->image) }}"
                            onerror="this.classList.add('hidden'); document.getElementById('noImageText').classList.remove('hidden');"
                            class="object-cover w-full h-full {{ $menu->image ? '' : 'hidden' }}">
                        <span id="noImageText" class="text-gray-400 text-sm {{ $menu->image ? 'hidden' : '' }}">Belum ada gambar</span>
                        <button type="button" id="removeImage"
                            class="absolute top-2 right-2 bg-white text-red-500 border border-red-300 rounded-full p-1 hover:bg-red-100 transition {{ $menu->image ? '' : 'hidden' }}">
                            &times;
                        </button>
                    </div>

                    <div class="mt-3">
                        <label for="image" class="block text-gray-700 font-semibold">Ganti Gambar</label>
                        <input type="file" name="image" id="image"
                            class="w-full mt-1 block text-sm text-gray-700 file:mr-3 file:py-1 file:px-3
                                file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                    </div>
                </div>

                <!-- Form Input -->
                <div class="w-full md:w-2/3 space-y-4">

                    <div>
                        <label for="name" class="block text-gray-700 font-semibold">Nama Menu</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label for="price" class="block text-gray-700 font-semibold">Harga</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label for="desc" class="block text-gray-700 font-semibold">Deskripsi</label>
                        <textarea name="desc" id="desc" rows="3" required
                            class="w-full px-4 py-2 border rounded-md">{{ old('desc', $menu->desc) }}</textarea>
                    </div>

                    <div>
                        <label for="stock" class="block text-gray-700 font-semibold">Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $menu->stock) }}" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label for="point" class="block text-gray-700 font-semibold">Poin</label>
                        <input type="number" name="point" id="point" value="{{ old('point', $menu->point) }}" required
                            class="w-full px-4 py-2 border rounded-md">
                    </div>

                    <div>
                        <label for="category" class="block text-gray-700 font-semibold">Kategori</label>
                        <select name="category" id="category" required
                            class="w-full px-4 py-2 border rounded-md">
                            <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="cemilan" {{ $menu->category == 'cemilan' ? 'selected' : '' }}>Cemilan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="bg-yellow-400 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-yellow-500 transition duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Script -->
    <script>
        const removeBtn = document.getElementById('removeImage');
        const previewImage = document.getElementById('previewImage');
        const noImageText = document.getElementById('noImageText');
        const fileInput = document.getElementById('image');

        removeBtn?.addEventListener('click', function () {
            previewImage.classList.add('hidden');
            noImageText.classList.remove('hidden');
            fileInput.value = '';
            previewImage.src = '';
        });

        fileInput?.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                previewImage.src = URL.createObjectURL(file);
                previewImage.classList.remove('hidden');
                noImageText.classList.add('hidden');
            } else {
                previewImage.classList.add('hidden');
                noImageText.classList.remove('hidden');
            }
        });
    </script>

</body>
</html>
