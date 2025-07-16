<nav class="bg-[#731b0c] p-4 text-white font-sans">
    <div class="container mx-auto flex items-center justify-between md:justify-center relative">
        <!-- Menu Kiri -->
        <ul class="hidden md:flex space-x-6 text-sm absolute left-[160px]">
            <li><a href="{{ route('dashboard') }}" class="hover:underline hover:text-yellow-300 transition duration-200">List Menu</a></li>
        </ul>

        <!-- Logo di Tengah -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10 mb-1">
            <span class="text-yellow-400 font-bold text-lg tracking-wide">Kampoeng Sawah</span>
        </div>

        <!-- Menu Kanan -->
        <ul class="hidden md:flex space-x-6 text-sm absolute right-[160px]">
            <li><a href="/accounts" class="hover:underline hover:text-yellow-300 transition duration-200">Accounts</a></li>
        </ul>

        <!-- Tombol Menu Mobile -->
        <button class="md:hidden block text-white text-2xl focus:outline-none" id="menu-toggle">☰</button>
    </div>

    <!-- Menu Mobile -->
    <div class="hidden md:hidden mt-2 bg-[#5b130a] p-4 rounded-lg space-y-2 shadow-lg" id="mobile-menu">
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded hover:bg-[#4a0f07] transition">Home</a>
        <a href="/galeri" class="block py-2 px-4 rounded hover:bg-[#4a0f07] transition">Galeri</a>
        <a href="/kontak" class="block py-2 px-4 rounded hover:bg-[#4a0f07] transition">Kontak</a>
        <a href="/menu" class="block py-2 px-4 rounded hover:bg-[#4a0f07] transition">Menu</a>
        <a href="/order" class="block py-2 px-4 rounded hover:bg-[#4a0f07] transition">Order</a>
    </div>
</nav>

<!-- Script untuk Toggle Menu Mobile -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");

        menuToggle.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });
    });
</script>