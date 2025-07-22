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
    <div class="h-64 w-full flex items-center justify-center overflow-hidden rounded-xl">
      <img src="{{ asset('images/diskon1.jpg') }}" alt="Promo 1" class="h-full object-contain border border-black rounded-xl">
    </div>
    <div class="h-64 w-full flex items-center justify-center overflow-hidden rounded-xl">
      <img src="{{ asset('images/diskon5.jpg') }}" alt="Promo 2" class="h-full object-contain border border-black rounded-xl">
    </div>
    <div class="h-64 w-full flex items-center justify-center overflow-hidden rounded-xl">
      <img src="{{ asset('images/diskon3.jpg') }}" alt="Promo 3" class="h-full object-contain border border-black rounded-xl">
    </div>
    <div class="h-64 w-full flex items-center justify-center overflow-hidden rounded-xl">
      <img src="{{ asset('images/diskon4.jpg') }}" alt="Promo 4" class="h-full object-contain border border-black rounded-xl">
    </div>
  </div>
</div>







  <!-- KATEGORI -->
  <div class="container mx-auto px-4 py-4">
    <div class="flex space-x-2">
      <button onclick="filterCategory('Semua', this)" class="category-button active-category px-4 py-2 border rounded">Semua</button>
      <button onclick="filterCategory('Makanan', this)" class="category-button px-4 py-2 border rounded">Makanan</button>
      <button onclick="filterCategory('Minuman', this)" class="category-button px-4 py-2 border rounded">Minuman</button>
      <button onclick="filterCategory('Cemilan', this)" class="category-button px-4 py-2 border rounded">Cemilan</button>
    </div>
  </div>

  <!-- SEARCH DAN PESANAN -->
  <div class="container mx-auto px-4 flex justify-between items-center mt-4">
    <input type="text" id="search" placeholder="Cari menu..." class="w-1/3 p-2 border rounded">
    <a href="/pesanan" class="bg-yellow-400 text-black px-4 py-2 rounded">Pesanan Saya</a>
  </div>

  <!-- MENU -->
  <div id="menu-container" class="container mx-auto px-4 py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 flex-grow"></div>

  <!-- PROFILE BUTTON -->
  <a href="/profile" class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-full shadow-lg border border-black">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.004 9.004 0 0112 15c2.072 0 3.98.707 5.465 1.898M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
  </a>

  <!-- FOOTER -->
  @include('partials.footer')

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

    function goToDetail(id) {
      window.location.href = `/menu/${id}`;
    }

    function renderMenu(items) {
      menuContainer.innerHTML = "";
      items.forEach(item => {
        const stars = getStarRating(item.rating || 0);
        menuContainer.innerHTML += `
          <div onclick="goToDetail(${item.id})" class="menu-item bg-white p-4 shadow rounded-xl flex items-center border border-black h-44 hover:bg-gray-100 transition cursor-pointer" data-category="${item.category}">
            <img src="/images/${item.image}" class="h-16 w-16 object-cover rounded-lg" alt="${item.name}">
            <div class="ml-4 flex-1">
              <h3 class="font-bold text-lg">${item.name}</h3>
              <p class="text-sm text-gray-600">${item.desc}</p>
              <div class="flex justify-between items-center mt-2">
                <p class="text-sm">Stok: ${item.stock}</p>
                <p class="text-sm font-semibold">Harga: ${item.price}</p>
              </div>
              <div class="mt-2 text-yellow-400 text-sm">${stars}</div>
            </div>
            <button onclick='event.stopPropagation(); addToCart(${JSON.stringify(item)})' class="ml-4 bg-yellow-400 px-3 py-1 rounded-full flex items-center justify-center text-sm font-bold border border-black hover:bg-yellow-300 transition">+</button>
          </div>`;
      });
    }

    function getStarRating(rating) {
      const fullStar = "★";
      const emptyStar = "☆";
      const maxStars = 5;
      const filledStars = Math.round(rating);
      return fullStar.repeat(filledStars) + emptyStar.repeat(maxStars - filledStars);
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
