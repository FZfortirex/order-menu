<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <!-- Navbar -->
    @include('partials-admin.navbar')

<div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-lg">
    
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Edit Menu</h2>

    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Nama Menu -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Menu</label>
            <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                   class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Harga -->
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" required
                   class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="desc" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="desc" id="desc" required
                      class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('desc', $menu->desc) }}</textarea>
        </div>

        <!-- Stok -->
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $menu->stock) }}" required
                   class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Poin -->
        <div>
            <label for="point" class="block text-sm font-medium text-gray-700">Poin</label>
            <input type="number" name="point" id="point" value="{{ old('point', $menu->point) }}" required
                   class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Kategori -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="category" id="category" required
                    class="mt-1 block w-full border border-gray-300 rounded-md px-4 py-2 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="cemilan" {{ $menu->category == 'cemilan' ? 'selected' : '' }}>Cemilan</option>
            </select>
        </div>

        <!-- Gambar -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar</label>
            <input type="file" name="image" id="image"
                   class="mt-1 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0 file:text-sm file:font-semibold
                          file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

            @if ($menu->image)
                <div class="mt-2">
                    <p class="text-xs text-gray-500">Gambar sekarang:</p>
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu" class="w-32 mt-1 rounded-md">
                </div>
            @endif
        </div>

        <!-- Tombol -->
        <div class="flex justify-between pt-4">
            <a href="{{ route('admin.menu') }}" class="text-sm text-gray-500 hover:text-blue-600 transition">
                ← Kembali
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-semibold transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

</body>
</html>
