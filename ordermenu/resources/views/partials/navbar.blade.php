<nav class="bg-[#731b0c] text-white font-sans shadow-md">
  <div class="container mx-auto flex justify-between items-center h-16 px-4 md:px-8">
    <!-- Kiri: Logo dan Nama -->
    <div class="flex items-center gap-x-3">
      <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10">
      <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
    </div>

    <!-- Kanan: Menu Navigasi Desktop -->
    <div class="hidden md:flex items-center gap-x-8 text-sm">
      <a href="{{ route('welcome') }}"
         class="{{ request()->routeIs('welcome') ? 'text-yellow-300' : 'hover:text-yellow-300' }}">
         Home
      </a>
      <a href="/galeri"
         class="{{ request()->is('galeri') ? 'text-yellow-300' : 'hover:text-yellow-300' }}">
         Galeri
      </a>
      <a href="{{ route('kontak') }}"
         class="{{ request()->routeIs('kontak') ? 'text-yellow-300' : 'hover:text-yellow-300' }}">
         Kontak
      </a>
      <a href="{{ auth()->check() ? route('order.menu') : route('loginAccount') }}"
         class="{{ request()->routeIs('order.menu') || request()->routeIs('loginAccount') ? 'text-yellow-300' : 'hover:text-yellow-300' }}">
         Menu
      </a>
    </div>

    <!-- Tombol Mobile -->
    <button id="menu-toggle" class="md:hidden text-2xl focus:outline-none">
      ☰
    </button>
  </div>

  <!-- Menu Mobile -->
<div id="mobile-menu"
  class="hidden absolute right-4 top-16 w-56 bg-[#5b130a] z-50 px-4 py-4 space-y-3 rounded-2xl shadow-2xl">

  <a href="{{ route('welcome') }}"
     class="block text-white text-base font-medium py-2 px-4 rounded-xl
     {{ request()->routeIs('welcome') ? 'bg-yellow-400 text-[#5b130a] font-semibold' : 'hover:bg-[#4a0f07]' }} transition duration-200 ease-in-out">
     Home
  </a>

  <a href="/profile"
     class="block text-white text-base font-medium py-2 px-4 rounded-xl
     {{ request()->is('galeri') ? 'bg-yellow-400 text-[#5b130a] font-semibold' : 'hover:bg-[#4a0f07]' }} transition duration-200 ease-in-out">
     Profile
  </a>

  <a href="/galeri"
     class="block text-white text-base font-medium py-2 px-4 rounded-xl
     {{ request()->is('galeri') ? 'bg-yellow-400 text-[#5b130a] font-semibold' : 'hover:bg-[#4a0f07]' }} transition duration-200 ease-in-out">
     Galeri
  </a>

  <a href="{{ route('kontak') }}"
     class="block text-white text-base font-medium py-2 px-4 rounded-xl
     {{ request()->routeIs('kontak') ? 'bg-yellow-400 text-[#5b130a] font-semibold' : 'hover:bg-[#4a0f07]' }} transition duration-200 ease-in-out">
     Kontak
  </a>

  <a href="{{ auth()->check() ? route('order.menu') : route('loginAccount') }}"
     class="block text-white text-base font-medium py-2 px-4 rounded-xl
     {{ request()->routeIs('order.menu') || request()->routeIs('loginAccount') ? 'bg-yellow-400 text-[#5b130a] font-semibold' : 'hover:bg-[#4a0f07]' }} transition duration-200 ease-in-out">
     Menu
  </a>
</div>

</nav>

<!-- Script untuk Toggle Menu Mobile -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("mobile-menu");

    toggle.addEventListener("click", function () {
      menu.classList.toggle("hidden");
    });
  });
</script>