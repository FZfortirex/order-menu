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
<body class="bg-gray-50 min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Konten Utama -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto py-12 px-6">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-10">
                <div class="flex items-center gap-4">
                    <a href="/listOrder" class="flex items-center text-gray-700 hover:text-yellow-600 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Menu</h1>
                </div>
                <a href="{{ route('menu.create') }}" class="mt-4 md:mt-0 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition">
                    Tambah Menu
                </a>
            </div>

            <!-- Daftar Menu -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($menus as $menu)
                    <div class="bg-white rounded-2xl shadow-md flex p-4 gap-4 hover:shadow-lg transition">
                        <img src="/images/{{ $menu->image }}" alt="{{ $menu->name }}" class="w-24 h-24 object-cover rounded-xl">

                        <div class="flex flex-col justify-between flex-1">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800">{{ $menu->name }}</h2>
                                <p class="text-sm text-gray-600">{{ $menu->desc }}</p>
                            </div>

                            <div class="flex justify-between text-sm text-gray-700 mt-2">
                                <span>Stok: {{ $menu->stock }}</span>
                                <span>
                                    @if($menu->discount_price)
                                        <span class="line-through italic text-red-500 mr-1">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                                        <span class="font-semibold text-gray-800">Rp{{ number_format($menu->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('menu.edit', $menu->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg">
                                    Edit
                                </a>
                                <form action="{{ route('menu.delete', $menu->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('partials-admin.footer')

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Konfirmasi Hapus</h2>
            <p class="text-sm text-gray-600 mb-5">Apakah kamu yakin ingin menghapus menu ini?</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm">Batal</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm">Hapus</button>
            </div>
        </div>
    </div>

    <!-- Script Hapus Konfirmasi -->
    <script>
        let formToSubmit = null;

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                formToSubmit = form;
                document.getElementById('confirmModal').classList.remove('hidden');
            });
        });

        document.getElementById('cancelDelete').addEventListener('click', () => {
            formToSubmit = null;
            document.getElementById('confirmModal').classList.add('hidden');
        });

        document.getElementById('confirmDelete').addEventListener('click', () => {
            if (formToSubmit) formToSubmit.submit();
        });
    </script>
</body>
</html>
