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
        <!-- Bagian atas: Tombol Back + Judul + Tombol Tambah Menu -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
            <div class="flex items-center gap-4">
                <!-- Tombol Back -->
                <a href="/listOrder" class="flex items-center text-gray-700 hover:text-yellow-600 font-semibold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
                <!-- Judul -->
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Menu</h1>
            </div>

            <!-- Tombol Tambah Menu -->
            <a href="{{ route('menu.create') }}" class="mt-4 md:mt-0 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition">
                Tambah Menu
            </a>
        </div>

        <!-- Daftar Menu -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <div class="bg-white rounded-2xl shadow-md flex p-4 gap-4 hover:shadow-lg transition">
                    <img src="/images/{{ $menu->image }}" alt="{{ $menu->name }}"
                         class="w-24 h-24 object-cover rounded-xl">

                    <div class="flex flex-col justify-between flex-1">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $menu->name }}</h2>
                            <p class="text-sm text-gray-600">{{ $menu->desc }}</p>
                        </div>

                        <div class="flex justify-between text-sm text-gray-700 mt-2">
                            <span>Stok: {{ $menu->stock }}</span>
                            <span>
                            @if($menu->discount_price)
                                <span class="line-through italic text-red-500 mr-1">
                                Rp{{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                                <span class="font-semibold text-gray-800">
                                Rp{{ number_format($menu->discount_price, 0, ',', '.') }}
                                </span>
                            @else
                                Rp{{ number_format($menu->price, 0, ',', '.') }}
                            @endif
                            </span>
                        </div>

                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('menu.edit', $menu->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg">
                                Edit
                            </a>
                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-lg">
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