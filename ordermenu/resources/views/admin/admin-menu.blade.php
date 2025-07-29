<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto py-12 px-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Menu</h1>
            <a href="{{ route('menu.create') }}" class="mt-4 md:mt-0 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition">
                Tambah Menu
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($menus as $menu)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
                <img src="/images/{{ $menu['image'] }}" alt="{{ $menu->name }}"
                     class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">

                <div class="p-5 space-y-2">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $menu->name }}</h2>
                    <p class="text-gray-600 text-sm">Deskripsi: <span class="font-medium text-gray-800">{{ $menu->desc }}</span></p>
                    <p class="text-gray-600 text-sm">Stok: <span class="font-medium text-gray-800">{{ $menu->stock }}</span></p>
                    <p class="text-gray-600 text-sm">Harga: <span class="font-bold text-green-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</span></p>

                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('menu.edit', $menu->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-4 py-2 rounded-lg transition">
                            Edit
                        </a>
                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-4 py-2 rounded-lg transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>
