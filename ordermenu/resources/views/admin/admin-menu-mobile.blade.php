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
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
                <div class="flex items-center gap-3">
                    <a href="/listOrder" class="flex items-center text-gray-700 hover:text-yellow-600 font-semibold text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back
                    </a>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Manajemen Menu</h1>
                </div>
                <div class="gap-4 flex items-center">
                    <button id="restockAllBtn" 
                        class="mt-4 md:mt-0 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition">
                        Restock Semua
                    </button>

                    <form id="restockForm" action="{{ route('menu.restock') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <!-- Modal Restock -->
                    <div id="restockModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-3">Konfirmasi Restock</h2>
                            <p class="text-sm text-gray-600 mb-5">
                                Masukkan jumlah stok baru untuk semua menu:
                            </p>
                            
                            <form id="restockForm" action="{{ route('menu.restock') }}" method="POST">
                                @csrf
                                <input type="number" name="stock" id="restockInput" 
                                    class="w-full border px-3 py-2 rounded-lg mb-4 text-sm focus:ring"
                                    min="1" value="50" required>
                                
                                <div class="flex justify-end gap-3">
                                    <button type="button" id="cancelRestock" 
                                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm">Batal</button>
                                    <button type="submit" 
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm">Ya, Restock</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('menu.create') }}" class="mt-4 md:mt-0 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-5 py-2 rounded-xl shadow transition">
                        Tambah Menu
                    </a>
                </div>
            </div>

            <!-- Search -->
            <div class="mb-6">
                <input type="text" id="searchInput" placeholder="Cari menu..."
                       class="w-full sm:w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <!-- Filter Category -->
            <div class="mb-6 flex flex-wrap gap-2">
                <button class="filter-btn bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm" data-category="all">Semua</button>
                <button class="filter-btn bg-gray-200 px-4 py-2 rounded-lg text-sm" data-category="makanan">Makanan</button>
                <button class="filter-btn bg-gray-200 px-4 py-2 rounded-lg text-sm" data-category="minuman">Minuman</button>
                <button class="filter-btn bg-gray-200 px-4 py-2 rounded-lg text-sm" data-category="cemilan">Cemilan</button>
                <button class="filter-btn bg-gray-200 px-4 py-2 rounded-lg text-sm" data-category="paket">Paket</button>
            </div>

            <!-- Daftar Menu -->
            <div id="menuList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($menus as $menu)
                    <div class="menu-item bg-white rounded-xl shadow-sm flex p-3 gap-3 hover:shadow-md transition"
                        data-name="{{ strtolower($menu->name) }}"
                        data-desc="{{ strtolower($menu->desc) }}"
                        data-category="{{ strtolower($menu->category) }}">
                        <img src="/images/{{ $menu->image }}" alt="{{ $menu->name }}" class="w-20 h-20 object-cover rounded-lg">

                        <div class="flex flex-col justify-between flex-1 text-sm">
                            <div>
                                <h2 class="font-semibold text-gray-800 text-base truncate">{{ $menu->name }}</h2>
                                <p class="text-xs text-gray-600 line-clamp-2">{{ $menu->desc }}</p>
                            </div>

                            <div class="flex justify-between items-center text-xs text-gray-700 mt-1">
                                <span>Stok: {{ $menu->stock }}</span>
                                <span>
                                    @if($menu->discount_price)
                                        <span class="line-through text-red-400 mr-1">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
                                        <span class="font-semibold text-gray-800">Rp{{ number_format($menu->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>

                            <div class="flex gap-2 mt-3">
                                <a href="{{ route('menu.edit', $menu->id) }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">
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
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Konfirmasi Hapus</h2>
            <p class="text-sm text-gray-600 mb-5">Apakah kamu yakin ingin menghapus menu ini?</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm">Batal</button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded text-sm">Hapus</button>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        let formToSubmit = null;
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                formToSubmit = form;

                // Ambil nama menu dari tombol
                const menuName = form.querySelector('.delete-btn').dataset.name;
                document.getElementById('menuNameToDelete').textContent = menuName;

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

        // Restock Semua
        document.getElementById("restockAllBtn").addEventListener("click", () => {
            document.getElementById("restockModal").classList.remove("hidden");
        });

        document.getElementById("cancelRestock").addEventListener("click", () => {
            document.getElementById("restockModal").classList.add("hidden");
        });

        document.getElementById("confirmRestock").addEventListener("click", () => {
            document.getElementById("restockForm").submit();
        });

        // Search filter
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.menu-item').forEach(item => {
                const name = item.getAttribute('data-name');
                const desc = item.getAttribute('data-desc');
                if (name.includes(query) || desc.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>

</body>
</html>
