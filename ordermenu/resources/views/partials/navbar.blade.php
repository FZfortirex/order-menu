<nav class="bg-[#731b0c] p-4">
<div class="container mx-auto grid grid-cols-3 items-center h-16 text-white bg-[#731b0c] px-8">
  <!-- Kiri: Home & Galeri -->
  <div class="flex gap-x-20 text-sm justify-center justify-self-center">
    <a href="{{ route('welcome') }}" class="cursor-pointer">Home</a>
    <a href="/galeri" class="cursor-pointer">Galeri</a>
    </div>

  <!-- Tengah: Logo -->
  <div class="flex flex-col items-center justify-self-center">
    <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10 mb-1">
    <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
  </div>

  <!-- Kanan: Kontak & Opsi -->
  <div class="flex gap-x-20 text-sm justify-center justify-self-center">
    <a href="{{ route('kontak') }}" class="cursor-pointer">Kontak</a>
    <a href="{{ auth()->check() ? route('order.menu') : route('loginAccount') }}" class="cursor-pointer">Menu</a>
  </div>

  <!-- Tombol Mobile (kalau perlu) -->
  <button class="md:hidden absolute right-4 block text-xl" id="menu-toggle">☰</button>
</div>



    <!-- Menu Mobile -->
    <div class="hidden md:hidden mt-2 bg-[#5b130a] p-2" id="mobile-menu">
        <a href="{{ route('welcome') }}" class="block py-2 px-4">Home</a>
        <a href="/galeri" class="block py-2 px-4">Galeri</a>
        <a href="{{ route('kontak') }}" class="block py-2 px-4">Kontak</a>
        <a href="{{ auth()->check() ? route('order.menu') : route('loginAccount') }}" class="block py-2 px-4">Menu</a>
        <a href="{{ auth()->check() ? route('pesanan') : route('loginAccount') }}" class="block py-2 px-4">Order</a>
    </div>
</nav>

<!-- Script untuk Toggle Menu Mobile -->
<script>
    document.getElementById("menu-toggle").addEventListener("click", function() {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>