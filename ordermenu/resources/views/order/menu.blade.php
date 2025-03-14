<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Waroeng Sawah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
</head>
<body class="min-h-screen bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-[#731b0c] p-4 text-white flex justify-between items-center">
        <div class="flex items-center">
            <img src="logo.png" alt="Logo" class="h-8 mr-2">
            <span class="text-yellow-400 font-bold text-lg md:text-xl">Waroeng Sawah</span>
        </div>
        <button class="md:hidden text-white text-xl">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Banner Promo -->
    <div class="container mx-auto px-4 py-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <img src="paket-ayam.png" class="w-full rounded-lg" alt="Paket Ayam">
            <img src="paket-nila.png" class="w-full rounded-lg" alt="Paket Nila">
            <img src="paket-nila.png" class="w-full rounded-lg" alt="Paket Nila">
        </div>
    </div>

    <!-- Kategori Menu -->
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <button class="flex items-center space-x-2 border px-3 py-2 rounded-lg bg-yellow-400">
            <i class="fas fa-hamburger"></i>
            <span>Makanan</span>
        </button>
        <button class="flex items-center space-x-2 border px-3 py-2 rounded-lg">
            <i class="fas fa-coffee"></i>
            <span>Minuman</span>
        </button>
        <button class="flex items-center space-x-2 border px-3 py-2 rounded-lg">
            <i class="fas fa-cookie"></i>
            <span>Cemilan</span>
        </button>
    </div>

    <!-- Daftar Menu -->
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Menu</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <div class="border p-4 rounded bg-white flex justify-between items-center">
                <div>
                    <img src="ayam-geprek.png" class="h-16 w-16 object-cover rounded-lg">
                    <h3 class="font-bold text-lg">Ayam Geprek</h3>
                    <p class="text-sm text-gray-600">Ayam Goreng dengan Geprekan khasnya</p>
                    <p class="text-sm font-semibold">Harga: Rp10.000</p>
                </div>
                <button class="bg-yellow-400 px-3 py-1 rounded-full">+</button>
            </div>
        </div>
    </div>

    <!-- Tombol Pesanan -->
    <div class="fixed bottom-0 w-full bg-white p-4 shadow-lg flex justify-center">
        <button class="bg-yellow-400 px-6 py-2 rounded-lg text-lg font-bold">Pesanan Saya</button>
    </div>

</body>
</html>
