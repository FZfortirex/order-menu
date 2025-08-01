<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kampoeng Sawah - Mobile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .active-category {
      @apply bg-yellow-400 text-black border-none;
    }
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

  <!-- NAVBAR -->
  @include('partials.navbar')

  <!-- CAROUSEL -->
  <div class="px-4 mt-4">
    <div class="flex overflow-x-auto snap-x snap-mandatory space-x-4 scrollbar-hide">
      @foreach (['diskon1.jpg','diskon5.jpg','diskon3.jpg','diskon4.jpg'] as $img)
        <div class="snap-center min-w-[85%] sm:min-w-0 rounded-xl overflow-hidden shadow-lg">
          <img src="{{ asset('images/' . $img) }}" class="w-full h-44 object-cover" />
        </div>
      @endforeach
    </div>
  </div>
  </div>

  <!-- KATEGORI -->
  <div class="mt-6 px-4">
    <div class="flex overflow-x-auto gap-2 scrollbar-hide pb-2">
      @foreach (['Semua', 'Makanan', 'Minuman', 'Cemilan'] as $cat)
        <button onclick="filterCategory('{{ $cat }}', this)"
          class="category-button whitespace-nowrap px-4 py-2 border rounded-full text-sm bg-white hover:bg-yellow-100 transition">
          {{ $cat }}
        </button>
      @endforeach
    </div>
  </div>

<!-- SEARCH + PESANAN -->
<div class="px-4 mt-4 flex flex-col gap-2">
  <input type="text" id="search" placeholder="Cari menu favorit..."
    class="w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" />
    <a href="/pesanan"
  class="w-full max-w-sm mx-auto bg-yellow-400 text-black text-center text-sm font-medium py-1.5 rounded-md shadow hover:bg-yellow-300 transition">
  Pesanan Saya
</a>

</div>

  <!-- MENU SECTION -->
  <div id="menu-container" class="container mx-auto px-4 py-6 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4"></div>

  @if(Auth::check() && !is_numeric(Auth::user()->name))
    <!-- PROFILE BUTTON -->
    <a href="/profile"
      class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-full shadow-lg border border-black">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M5.121 17.804A9.004 9.004 0 0112 15c2.072 0 3.98.707 5.465 1.898M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </a>
  @endif

  <!-- FOOTER -->
  @include('partials.footer')

  <!-- SCRIPT -->
  <script>
    const menuContainer = document.getElementById("menu-container");
    const searchInput = document.getElementById("search");
    let menuItems = [];

    async function getMenus() {
      try {
        const res = await fetch("/api/menus");
        menuItems = await res.json();
        renderMenu(menuItems);
      } catch (err) {
        console.error("Gagal memuat menu:", err);
      }
    }

    function goToDetail(id) {
      window.location.href = `/menu/${id}`;
    }

    function renderMenu(items) {
      menuContainer.innerHTML = "";
      items.forEach(item => {
        const stars = getStarRating(item.rating || 0);
        menuContainer.innerHTML += `
          <div onclick="goToDetail(${item.id})" class="menu-item bg-white p-2 rounded-lg shadow border hover:bg-gray-50 transition cursor-pointer" data-category="${item.category}">
            <img src="/images/${item.image}" class="w-full h-28 object-cover rounded-md mb-2" alt="${item.name}">
            <h3 class="font-bold text-sm truncate">${item.name}</h3>
            <p class="text-xs text-gray-600 truncate">${item.desc}</p>
            <div class="text-xs mt-1 flex justify-between items-center">
              <span>Stok: ${item.stock}</span>
              ${item.discount_price ? `
                <div class="text-right">
                  <div class="text-[10px] text-red-500 line-through italic">Rp${parseInt(item.price).toLocaleString('id-ID')}</div>
                  <div class="text-xs font-semibold text-black">Rp${parseInt(item.discount_price).toLocaleString('id-ID')}</div>
                </div>` : `
                <div class="text-xs font-semibold text-black">Rp${parseInt(item.price).toLocaleString('id-ID')}</div>`}
            </div>
            <div class="text-xs text-yellow-400 mt-1">
              ${item.review_count > 0 ? `${stars} (${item.review_count})` : 'Belum ada ulasan'}
            </div>
          </div>`;
      });
    }

    function getStarRating(rating) {
      const full = Math.floor(rating);
      const half = rating % 1 >= 0.5;
      const empty = 5 - full - (half ? 1 : 0);
      return '★'.repeat(full) + (half ? '½' : '') + '☆'.repeat(empty);
    }

    function filterCategory(category, clickedBtn) {
      document.querySelectorAll(".category-button").forEach(btn => btn.classList.remove("active-category"));
      clickedBtn.classList.add("active-category");
      const filtered = category === "Semua" ? menuItems : menuItems.filter(item => item.category === category);
      renderMenu(filtered);
    }

    function searchMenu() {
      const input = searchInput.value.toLowerCase();
      document.querySelectorAll(".menu-item").forEach(item => {
        const title = item.querySelector("h3").innerText.toLowerCase();
        item.style.display = title.includes(input) ? "block" : "none";
      });
    }

    document.addEventListener("DOMContentLoaded", () => {
      getMenus();
      searchInput.addEventListener("keyup", searchMenu);
    });
  </script>
</body>
</html>
