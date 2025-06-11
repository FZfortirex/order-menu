<nav class="bg-[#731b0c] p-4">
    <div class="container mx-auto flex items-center justify-between md:justify-center relative">
        <!-- Menu Kiri -->
        <ul class="hidden md:flex space-x-6 text-sm absolute left-0">
            <li><a href="{{ route('dashboard') }}" class="text-white hover:underline">List Menu</a></li>
        </ul>

        <!-- Logo di Tengah -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10">
            <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
        </div>

        <!-- Menu Kanan -->
        <ul class="hidden md:flex space-x-6 text-sm absolute right-0">
            <li><a href="/accounts" class="text-white hover:underline">Accounts</a></li>
        </ul>

        <!-- Tombol Menu Mobile -->
        <button class="md:hidden block text-white" id="menu-toggle">☰</button>
    </div>

    <!-- Menu Mobile -->
    <div class="hidden md:hidden mt-2 bg-[#5b130a] p-2 rounded" id="mobile-menu">
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-white hover:bg-[#4a0f07] rounded">Home</a>
        <a href="/galeri" class="block py-2 px-4 text-white hover:bg-[#4a0f07] rounded">Galeri</a>
        <a href="/kontak" class="block py-2 px-4 text-white hover:bg-[#4a0f07] rounded">Kontak</a>
        <a href="/menu" class="block py-2 px-4 text-white hover:bg-[#4a0f07] rounded">Menu</a>
        <a href="/order" class="block py-2 px-4 text-white hover:bg-[#4a0f07] rounded">Order</a>
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
