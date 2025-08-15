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
      @foreach ($banners as $banner)
        @if ($banner->menu_id)
        <div class="snap-center min-w-[85%] sm:min-w-0 rounded-xl overflow-hidden shadow-lg">
          <a href="{{ url('/menu/' . $banner->menu_id) }}">
            <img src="{{ asset($banner->image) }}" class="w-full h-44 object-cover" />
          </a>
        </div>
        @else
        <div class="snap-center min-w-[85%] sm:min-w-0 rounded-xl overflow-hidden shadow-lg">
          <img src="{{ asset($banner->image) }}" class="w-full h-44 object-cover" />
        </div>
        @endif
      @endforeach
    </div>
  </div>
  </div>

  <!-- KATEGORI -->
  <div class="mt-6 px-4">
    <div class="flex overflow-x-auto gap-2 scrollbar-hide pb-2">
      @foreach (['Semua', 'Makanan', 'Minuman', 'Cemilan'] as $menu)
        <button onclick="filterCategory('{{ $menu }}', this)"
          class="category-button whitespace-nowrap px-4 py-2 border rounded-[12px] text-sm bg-white hover:bg-yellow-300 transition">
          {{ $menu }}
        </button>
      @endforeach
    </div>
  </div>

<!-- SEARCH + PESANAN -->
<div class="px-4 mt-4 flex flex-col gap-2">
  <input type="text" id="search" placeholder="Cari Menu..."
    class="w-full p-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" />
</div>

  <!-- MENU SECTION -->
  <div id="menu-container" class="container mx-auto px-4 py-6 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4"></div>

    <!-- PESANAN SAYA BUTTON -->
    <a href="/pesanan"
      class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-[12px] shadow-lg border border-black flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.25 3h1.5l1.5 12h13.5l1.5-8H6.75M16.5 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-7.5 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
      </svg>
      <p>Pesanan Saya</p>
    </a>

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

    function goToDetail(id, stock) {
      if (stock <= 0) {
        window.location.href = "/menu"; 
      } else {
        window.location.href = `/menu/${id}`;
      }
    }

    function renderMenu(items) {
      menuContainer.innerHTML = "";
      items.forEach(item => {
        const stars = getStarRating(item.rating || 0);
        const isOutOfStock = item.stock <= 0;

        menuContainer.innerHTML += `
          <div 
            ${isOutOfStock ? '' : `onclick="goToDetail(${item.id}, ${item.stock})"`}
            class="menu-item bg-white p-2 rounded-lg shadow border 
            ${isOutOfStock ? 'opacity-80 cursor-not-allowed pointer-events-none' : 'hover:bg-gray-50 cursor-pointer'} 
            transition" 
            data-category="${item.category}">
            
            <img src="/images/${item.image}" class="w-full h-28 object-cover rounded-md mb-2" alt="${item.name}">
            <h3 class="font-bold text-sm truncate">${item.name}</h3>
            <p class="text-xs text-gray-600 truncate">${item.desc}</p>

            <div class="text-xs mt-1 flex justify-between items-center">
              <p class="text-sm ${isOutOfStock ? 'text-black' : ''}">
                  Stok: ${isOutOfStock ? 'Habis' : item.stock}
              </p>
              ${item.discount_price ? `
                <div class="text-right">
                  <div class="text-[10px] text-red-500 line-through italic">Rp${parseInt(item.price).toLocaleString('id-ID')}</div>
                  <div class="text-xs font-semibold text-black">Rp${parseInt(item.discount_price).toLocaleString('id-ID')}</div>
                </div>` : `
                <div class="text-xs font-semibold text-black">Rp${parseInt(item.price).toLocaleString('id-ID')}</div>`
              }
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
