<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kampoeng Sawah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #731b0c;
            color: white;
            background-image: url('https://pin.it/78jpK64Zs');
            background-size: cover;
            background-position: center;
        }
        .btn-hover:hover {
            background-color: #ffcc00;
            color: #5b130a;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

   <!-- Navbar -->
<nav class="bg-[#731b0c] p-4">
    <div class="container mx-auto flex items-center justify-between md:justify-center relative">
        <!-- Menu Kiri -->
        <ul class="hidden md:flex space-x-6 text-sm absolute left-0">
            <li><a href="/" class="hover:underline">Home</a></li>
            <li><a href="/galeri" class="hover:underline">Galeri</a></li>
        </ul>

        <!-- Logo di Tengah -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10">
            <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
        </div>

        <!-- Menu Kanan -->
        <ul class="hidden md:flex space-x-6 text-sm absolute right-0">
            <li><a href="/kontak" class="hover:underline">Kontak</a></li>
            <li class="relative group">
                <button class="hover:underline">Opsi ▼</button>
                <ul class="absolute hidden bg-[#5b130a] text-white p-2 rounded-md group-hover:block">
                    <li><a href="/menu" class="block py-1 px-3">Menu</a></li>
                    <li><a href="/order" class="block py-1 px-3">Order</a></li>
                    <li><a href="/waiter" class="block py-1 px-3">Waiter</a></li>
                </ul>
            </li>
        </ul>

        <!-- Tombol Menu Mobile -->
        <button class="md:hidden block" id="menu-toggle">☰</button>
    </div>

    <!-- Menu Mobile -->
    <div class="hidden md:hidden mt-2 bg-[#5b130a] p-2" id="mobile-menu">
        <a href="/" class="block py-2 px-4">Home</a>
        <a href="/galeri" class="block py-2 px-4">Galeri</a>
        <a href="/kontak" class="block py-2 px-4">Kontak</a>
        <a href="/menu" class="block py-2 px-4">Menu</a>
        <a href="/order" class="block py-2 px-4">Order</a>
        <a href="/waiter" class="block py-2 px-4">Waiter</a>
    </div>
</nav>

<!-- Script untuk Toggle Menu Mobile -->
<script>
    document.getElementById("menu-toggle").addEventListener("click", function() {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>


    <!-- Main Content -->
    <div class="flex items-center justify-center h-screen text-center">
    <div class="container mx-auto p-6">
        <h1 class="text-lg font-bold">RUMAH MAKAN</h1>
        <h2 class="text-3xl md:text-5xl font-extrabold text-yellow-400">KAMPOENG SAWAH</h2>
        <p class="mt-4 text-sm md:text-lg max-w-xl mx-auto">
            Dengan menggunakan website ini, maka akan memudahkan kita untuk order makanan restaurant tanpa menunggu waiter menghampirinya.
        </p>
        <a href="/menu">
                <button class="bg-yellow-400 text-[#731b0c] px-6 py-2 mt-6 rounded-full font-bold btn-hover">Pesan Sekarang</button>
            </a>
    </div>
</div>


<footer class="bg-black text-white py-6 text-center">
    <div class="container mx-auto">
        <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="mx-auto w-16 md:w-20 mb-2">
        <h2 class="text-yellow-400 font-bold text-sm md:text-lg">Kampoeng Sawah</h2>
        <!-- Menu hanya muncul di desktop -->
        <nav class="hidden md:flex justify-center space-x-8 mt-4">
            <a href="#" class="hover:text-yellow-400">Home</a>
            <a href="#" class="hover:text-yellow-400">Galeri</a>
            <a href="#" class="hover:text-yellow-400">Kontak</a>
            <a href="#" class="hover:text-yellow-400">Opsi</a>
        </nav>
        <p class="text-xs md:text-sm mt-2">&copy; 2025 Kampoeng Sawah</p>
    </div>
</footer>

    <script>
        document.getElementById("menu-toggle").addEventListener("click", function() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });
    </script>

</body>
</html>
