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
      border: none;
    }
  </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
  <!-- Navbar -->
  <nav class="bg-[#731b0c] text-white p-4 flex justify-between items-center">
    <span class="text-yellow-400 font-bold text-lg">Kampoeng Sawah</span>
    <div class="hidden md:flex space-x-6">
      <a href="#" class="hover:underline">Home</a>
      <a href="#" class="hover:underline">Galeri</a>
      <a href="#" class="hover:underline">Kontak</a>
      <a href="#" class="hover:underline">Opsi</a>
    </div>
    <button class="md:hidden text-xl">&#9776;</button>
  </nav>

  <!-- Kategori -->
  <div class="container mx-auto px-4 py-4">
    <div class="flex space-x-4">
      <button class="category-button px-4 py-2 border rounded active-category" onclick="filterCategory('Semua')">Semua</button>
      <button class="category-button px-4 py-2 border rounded" onclick="filterCategory('Makanan')">Makanan</button>
      <button class="category-button px-4 py-2 border rounded" onclick="filterCategory('Minuman')">Minuman</button>
      <button class="category-button px-4 py-2 border rounded" onclick="filterCategory('Cemilan')">Cemilan</button>
    </div>
  </div>

  <!-- Pencarian -->
  <div class="container mx-auto px-4 flex justify-between items-center mt-4">
    <input type="text" id="search" onkeyup="searchMenu()" placeholder="Cari menu..." class="w-1/3 p-2 border rounded">
    <a href="pesanan" class="bg-yellow-400 text-black px-4 py-2 rounded">Pesanan Saya</a>
  </div>

  <!-- Daftar Menu -->
  <div id="menu-container" class="container mx-auto px-4 py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 flex-grow"></div>

  <!-- Footer -->
  <footer class="bg-black text-white p-4 text-center mt-auto">
    <p>&copy; 2025 Kampoeng Sawah</p>
    <div class="flex justify-center space-x-4">
      <a href="#" class="hover:underline">Home</a>
      <a href="#" class="hover:underline">Galeri</a>
      <a href="#" class="hover:underline">Kontak</a>
      <a href="#" class="hover:underline">Opsi</a>
    </div>
  </footer>

  <!-- Script -->
  <script>
    const menuItems = [
      // Makanan
      { name: "Ayam Geprek", desc: "Ayam Goreng dengan Geprekan khasnya", img: "ayam-geprek.png", stock: 10, price: "10rb", category: "Makanan" },
      { name: "Nasi Goreng", desc: "Nasi goreng spesial kampung", img: "nasgor.png", stock: 8, price: "12rb", category: "Makanan" },
      { name: "Bakso", desc: "Bakso daging sapi asli", img: "bakso.png", stock: 15, price: "13rb", category: "Makanan" },
      { name: "Mie Goreng", desc: "Mie goreng pedas manis", img: "miegoreng.png", stock: 11, price: "10rb", category: "Makanan" },
      { name: "Sate Ayam", desc: "Sate ayam bumbu kacang", img: "sate.png", stock: 9, price: "15rb", category: "Makanan" },
      { name: "Ayam Bakar", desc: "Ayam bakar dengan bumbu khas", img: "ayam-bakar.png", stock: 12, price: "20rb", category: "Makanan" },
      { name: "Ikan Bakar", desc: "Ikan bakar segar dengan sambal", img: "ikan-bakar.png", stock: 10, price: "30rb", category: "Makanan" },
      { name: "Udang Saus Padang", desc: "Udang segar dengan saus pedas", img: "udang.png", stock: 8, price: "35rb", category: "Makanan" },
      { name: "Gurame Asam Manis", desc: "Gurame segar dengan saus asam manis", img: "gurame.png", stock: 9, price: "40rb", category: "Makanan" },

      // Minuman
      { name: "Jus Jeruk", desc: "Segarnya jeruk peras", img: "jusjeruk.png", stock: 13, price: "6rb", category: "Minuman" },
      { name: "Es Teh", desc: "Teh manis dingin", img: "esteh.png", stock: 20, price: "4rb", category: "Minuman" },
      { name: "Es Campur", desc: "Campuran es segar", img: "escampur.png", stock: 12, price: "8rb", category: "Minuman" },
      { name: "Kopi Hitam", desc: "Kopi hitam pekat", img: "kopi.png", stock: 10, price: "5rb", category: "Minuman" },

      // Cemilan
      { name: "Pisang Goreng", desc: "Pisang goreng renyah", img: "pisang.png", stock: 10, price: "5rb", category: "Cemilan" },
      { name: "Tahu Crispy", desc: "Tahu goreng kriuk", img: "tahu.png", stock: 14, price: "5rb", category: "Cemilan" },
      { name: "Tempe Mendoan", desc: "Tempe goreng tipis", img: "tempe.png", stock: 18, price: "4rb", category: "Cemilan" }
    ];

    function renderMenu(items) {
      const container = document.getElementById("menu-container");
      container.innerHTML = "";
      items.forEach(item => {
        container.innerHTML += `
          <div class="menu-item bg-white p-4 shadow rounded-xl flex items-center border border-black h-32" data-category="${item.category}">
            <img src="${item.img}" class="h-16 w-16 object-cover rounded-lg" alt="${item.name}">
            <div class="ml-4 flex-1">
              <h3 class="font-bold text-lg">${item.name}</h3>
              <p class="text-sm text-gray-600">${item.desc}</p>
              <div class="flex justify-between items-center mt-2">
                <p class="text-sm">Stok: ${item.stock}</p>
                <p class="text-sm font-semibold">Harga: ${item.price}</p>
              </div>
            </div>
            <button onclick='addToCart(${JSON.stringify(item)})' class="ml-4 bg-yellow-400 px-5 py-3 rounded-full flex items-center justify-center text-xl font-bold border border-black">+</button>
          </div>
        `;
      });
    }

    function filterCategory(category) {
      const buttons = document.querySelectorAll(".category-button");
      buttons.forEach(btn => btn.classList.remove("active-category"));
      event.target.classList.add("active-category");

      let filtered = (category === "Semua") ? menuItems : menuItems.filter(item => item.category === category);
      renderMenu(filtered);
    }

    function searchMenu() {
      let input = document.getElementById("search").value.toLowerCase();
      let allItems = document.getElementsByClassName("menu-item");

      for (let i = 0; i < allItems.length; i++) {
        let title = allItems[i].getElementsByTagName("h3")[0].innerText.toLowerCase();
        allItems[i].style.display = title.includes(input) ? "flex" : "none";
      }
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
    alert(item.name + " ditambahkan ke Pesanan Saya (Server)");
  })
  .catch(err => console.error("Error:", err));
}


    document.addEventListener("DOMContentLoaded", () => {
      renderMenu(menuItems); // default semua
    });
  </script>
</body>
</html>
