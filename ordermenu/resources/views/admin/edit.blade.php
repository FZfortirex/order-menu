<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Edit Menu</h2>

        <form action="{{ route('menu.update', $menu->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Menu -->
<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Nama Menu</label>
    <input
        type="text"
        name="name"  {{-- ← sebelumnya "nama" --}}
        id="name"
        value="{{ old('name', $menu->name) }}"
        required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
    >
</div>

<!-- Harga -->
<div>
    <label for="price" class="block text-sm font-medium text-gray-700">Harga</label>
    <input
        type="number"
        name="price" {{-- ← sebelumnya "harga" --}}
        id="price"
        value="{{ old('price', $menu->price) }}"
        required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
    >
</div>

<!-- Deskripsi -->
<div>
    <label for="desc" class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea
        name="desc"
        id="desc"
        required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
    >{{ old('desc', $menu->desc) }}</textarea>
</div>

<!-- Stok -->
<div>
    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
    <input
        type="number"
        name="stock" {{-- ← sebelumnya "stok" --}}
        id="stock"
        value="{{ old('stock', $menu->stock) }}"
        required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
    >
</div>



            <!-- Tombol Simpan -->
            <div class="flex justify-between">
                <a href="{{ route('order.menu') }}" class="inline-block text-sm text-gray-500 hover:text-blue-600 transition">
                    ← Kembali
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>
