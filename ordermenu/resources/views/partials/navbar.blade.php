<nav class="bg-[#731b0c] p-4">
    <div class="container mx-auto flex items-center justify-between md:justify-center relative">
        <!-- Menu Kiri -->
        <ul class="hidden md:flex space-x-6 text-sm absolute left-0">
            <li><a href="{{ route('welcome') }}" class="hover:underline">Home</a></li>
            <li><a href="/galeri" class="hover:underline">Galeri</a></li>
        </ul>

        <!-- Logo di Tengah -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10">
            <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
        </div>

        <!-- Menu Kanan -->
        <ul class="hidden md:flex space-x-6 text-sm absolute right-0">
        <li><a href="{{ route('kontak') }}" class="hover:underline">Kontak</a></li>
            <li class="relative group">
                <button class="hover:underline">Opsi ▼</button>
                <ul class="absolute hidden bg-[#5b130a] text-white p-2 rounded-md group-hover:block">
                    <li><a href="/menu" class="block py-1 px-3">Menu</a></li>
                    <li><a href="/order" class="block py-1 px-3">List Order</a></li>
                </ul>
            </li>
        </ul>

        <!-- Tombol Menu Mobile -->
        <button class="md:hidden block" id="menu-toggle">☰</button>
    </div>

    <!-- Menu Mobile -->
    <div class="hidden md:hidden mt-2 bg-[#5b130a] p-2" id="mobile-menu">
        <a href="{{ route('welcome') }}" class="block py-2 px-4">Home</a>
        <a href="/galeri" class="block py-2 px-4">Galeri</a>
        <a href="{{ route('kontak') }}" class="block py-2 px-4">Kontak</a>
        <a href="/menu" class="block py-2 px-4">Menu</a>
        <a href="/order" class="block py-2 px-4">Order</a>
    </div>
</nav>

<!-- Script untuk Toggle Menu Mobile -->
<script>
    document.getElementById("menu-toggle").addEventListener("click", function() {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>