<nav class="bg-[#731b0c] text-white font-sans shadow-md">
  <div class="max-w-screen-xl mx-auto px-4 py-4 flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center space-x-3">
      <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="h-10">
      <span class="text-yellow-400 font-bold text-lg tracking-wide">Kampoeng Sawah</span>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center space-x-10">
      <a href="{{ route('dashboard') }}"
         class="text-sm {{ request()->routeIs('dashboard') ? 'text-yellow-300' : 'hover:text-yellow-300' }} transition duration-200">
         List Menu
      </a>
      <a href="/accounts"
         class="text-sm {{ request()->is('accounts') ? 'text-yellow-300' : 'hover:text-yellow-300' }} transition duration-200">
         Accounts
      </a>
    </div>

    <!-- Mobile Toggle -->
    <button id="menu-toggle" class="md:hidden text-2xl focus:outline-none">
      ☰
    </button>
  </div>

  <!-- Mobile Menu -->
<div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
  <div class="bg-[#5b130a] rounded-2xl p-4 space-y-3 shadow-xl border border-[#a12d1c] animate-slide-down">
    <a href="{{ route('dashboard') }}"
       class="block py-3 px-5 rounded-xl text-sm font-medium text-white bg-opacity-10 backdrop-blur-sm transition-all duration-200
              {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-[#5b130a]' : 'hover:bg-[#4a0f07]' }}">
       List Menu
    </a>
    <a href="/accounts"
       class="block py-3 px-5 rounded-xl text-sm font-medium text-white bg-opacity-10 backdrop-blur-sm transition-all duration-200
              {{ request()->is('accounts') ? 'bg-yellow-400 text-[#5b130a]' : 'hover:bg-[#4a0f07]' }}">
       Accounts
    </a>
  </div>
</div>

</nav>

<!-- Script -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("menu-toggle");
    const menu = document.getElementById("mobile-menu");

    toggle.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });
  });
</script>

<!-- Animasi -->
<style>
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .animate-slide-down {
    animation: slideDown 0.3s ease-out;
  }
</style>
