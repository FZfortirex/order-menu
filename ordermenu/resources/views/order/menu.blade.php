<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .active-category {
      background-color: #facc15;
      color: black;
      border: none;
    }
  </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

  <!-- NAVBAR -->
  @include('partials.navbar')

  <!-- CAROUSEL PROMO DISKON -->
<div class="container mx-auto px-2 mt-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
    @foreach ($banners as $banner)
        @if ($banner->menu_id)
          <a href="{{ url('/menu/' . $banner->menu_id) }}">
            <img src="{{ asset($banner->image) }}" class="w-full aspect-[4/3] object-cover hover:scale-105 transition duration-300 rounded-lg">
          </a>
        @else
          <img src="{{ asset($banner->image) }}" class="w-full aspect-[4/3] object-cover hover:scale-105 transition duration-300 rounded-lg">
        @endif
    @endforeach
  </div>
</div>


  <!-- KATEGORI -->
  <div class="container mx-auto px-4 py-4">
    <div class="flex space-x-2">
      <button onclick="filterCategory('Semua', this)" class="category-button active-category px-4 py-2 border rounded">Semua</button>
      <button onclick="filterCategory('Makanan', this)" class="category-button px-4 py-2 border rounded">Makanan</button>
      <button onclick="filterCategory('Minuman', this)" class="category-button px-4 py-2 border rounded">Minuman</button>
      <button onclick="filterCategory('Cemilan', this)" class="category-button px-4 py-2 border rounded">Cemilan</button>
      <button onclick="filterCategory('Paket', this)" class="category-button px-4 py-2 border rounded">Paket</button>
    </div>
  </div>

  <!-- SEARCH DAN PESANAN -->
  <div class="container mx-auto px-4 flex justify-between items-center mt-4">
    <input type="text" id="search" placeholder="Cari menu..." class="w-1/3 p-2 border rounded">
  </div>

  <!-- MENU -->
  <div id="menu-container" class="container mx-auto px-4 py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 flex-grow"></div>

    <!-- Tombol Profile -->
    <a href="/pesanan"
      class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-[12px] shadow-lg border border-black flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.25 3h1.5l1.5 12h13.5l1.5-8H6.75M16.5 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-7.5 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
      </svg>
      <p>Pesanan Saya</p>
    </a>

  <!-- SCRIPT -->
  <script>
    const menuContainer = document.getElementById("menu-container");
    const searchInput = document.getElementById("search");

    // --- Menu ---
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
        const isOutOfStock = item.stock <= 0;

        menuContainer.innerHTML += `
          <div 
            class="menu-item bg-white p-4 shadow rounded-xl flex items-center border border-black h-44 transition ${isOutOfStock ? 'opacity-80 cursor-not-allowed' : 'hover:bg-gray-100 cursor-pointer'}"
            data-category="${item.category}"
            ${!isOutOfStock ? `onclick="goToDetail(${item.id}, ${item.stock})"` : ''}>
            
            <img src="/images/${item.image}" class="h-16 w-16 object-cover rounded-lg" alt="${item.name}">
            
            <div class="ml-4 flex-1">
              <h3 class="font-bold text-lg">${item.name}</h3>
              <p class="text-sm text-gray-600">${item.desc}</p>
              <div class="flex justify-between items-center mt-1">
                <p class="text-sm ${isOutOfStock ? 'text-black' : ''}">
                  Stok: ${isOutOfStock ? 'Habis' : item.stock}
                </p>
                ${
                  item.discount_price
                    ? `
                      <div class="text-right">
                        <div class="text-xs text-red-500 line-through italic">
                          Rp${parseInt(item.price).toLocaleString('id-ID')}
                        </div>
                        <div class="text-sm font-semibold text-black">
                          Rp${parseInt(item.discount_price).toLocaleString('id-ID')}
                        </div>
                      </div>
                    `
                    : `
                      <div class="text-sm font-semibold text-black">
                        Rp${parseInt(item.price).toLocaleString('id-ID')}
                      </div>
                    `
                }
              </div>
              <div class="text-sm text-yellow-400">
                ${item.review_count > 0
                  ? `${getStarRating(item.rating)} (${item.review_count})`
                  : 'Belum ada ulasan'}
              </div>
            </div>

            ${
              !isOutOfStock
                ? `<button onclick="goToDetail(${item.id}, ${item.stock})"
                    class="ml-4 w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-base font-bold border hover:bg-yellow-300 transition">
                    +
                  </button>`
                : `<button disabled
                    class="ml-4 w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-base font-bold border cursor-not-allowed">
                    ×
                  </button>`
            }
          </div>`;
      });
    }

    function getStarRating(rating) {
      const fullStars = Math.floor(rating);
      const halfStar = rating % 1 >= 0.5;
      const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

      return '★'.repeat(fullStars) + (halfStar ? '½' : '') + '☆'.repeat(emptyStars);
    }

    function filterCategory(category, clickedBtn) {
      document.querySelectorAll(".category-button").forEach(btn => btn.classList.remove("active-category"));
      clickedBtn.classList.add("active-category");

      const filtered = category === "Semua"
        ? menuItems
        : menuItems.filter(item => item.category === category);
      renderMenu(filtered);
    }

    function searchMenu() {
      const input = searchInput.value.toLowerCase();
      document.querySelectorAll(".menu-item").forEach(item => {
        const title = item.querySelector("h3").innerText.toLowerCase();
        item.style.display = title.includes(input) ? "flex" : "none";
      });
    }

    function addToCart(item) {
      fetch("/tambah-pesanan", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(item)
      })
      .then(res => res.json())
      .then(data => {
        alert(item.name + " ditambahkan ke Pesanan Saya!");
      })
      .catch(err => console.error("Error:", err));
    }

    document.addEventListener("DOMContentLoaded", () => {
      getMenus();
      searchInput.addEventListener("keyup", searchMenu);
    });
  </script>

</body>
</html>