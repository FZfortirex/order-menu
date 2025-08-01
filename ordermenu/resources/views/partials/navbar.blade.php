<nav class="bg-[#731b0c] p-4">
<div class="container mx-auto flex justify-between items-center h-16 text-white px-4 md:px-8">

  <!-- Kiri: Logo dan Nama -->
  <div class="flex items-center gap-x-3">
    <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10">
    <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
  </div>

  <!-- Kanan: Menu Navigasi -->
  <div class="hidden md:flex gap-x-8 text-sm items-center">
    <a href="{{ route('welcome') }}" class="hover:underline">Home</a>
    <a href="/galeri" class="hover:underline">Galeri</a>
    <a href="{{ route('kontak') }}" class="hover:underline">Kontak</a>
    <a href="{{ auth()->check() ? route('order.menu') : route('loginAccount') }}" class="hover:underline">Menu</a>

  </div>

  <!-- Tombol Mobile -->
    <button class="md:hidden text-xl" id="menu-toggle">☰</button>
  </div>

  <!-- Menu Mobile -->
  <div class="hidden md:hidden mt-2 bg-[#5b130a] p-2" id="mobile-menu">
    <a href="{{ route('welcome') }}" class="block py-2 px-4">Home</a>
    <a href="/galeri" class="block py-2 px-4">Galeri</a>
    <a href="{{ route('kontak') }}" class="block py-2 px-4">Kontak</a>
    <a href="{{ auth()->check() ? route('order.menu') : route('loginAccount') }}" class="block py-2 px-4">Menu</a>
  </div>
</nav>

<!-- Script untuk Toggle Menu Mobile -->
<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
      document.getElementById("mobile-menu").classList.toggle("hidden");
  });
</script>