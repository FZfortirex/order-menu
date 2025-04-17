<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kampoeng Sawah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function searchMenu() {
            let input = document.getElementById("search").value.toLowerCase();
            let items = document.getElementsByClassName("menu-item");

            for (let i = 0; i < items.length; i++) {
                let title = items[i].getElementsByTagName("h3")[0].innerText.toLowerCase();
                if (title.includes(input)) {
                    items[i].style.display = "flex";
                } else {
                    items[i].style.display = "none";
                }
            }
        }

        function setActive(category) {
            localStorage.setItem("activeCategory", category);
        }

        document.addEventListener("DOMContentLoaded", function() {
            let activeCategory = localStorage.getItem("activeCategory") || "Cemilan";
            let buttons = document.querySelectorAll(".category-button");

            buttons.forEach(btn => {
                if (btn.innerText === activeCategory) {
                    btn.classList.add("bg-yellow-400");
                    btn.classList.remove("border");
                } else {
                    btn.classList.remove("bg-yellow-400");
                    btn.classList.add("border");
                }
            });
        });
    </script>
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

    <!-- Banner Promo -->
    <div class="container mx-auto px-4 py-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <img src="cemilan-1.png" class="w-full rounded-lg" alt="Cemilan 1">
            <img src="cemilan-2.png" class="w-full rounded-lg" alt="Cemilan 2">
            <img src="cemilan-3.png" class="w-full rounded-lg" alt="Cemilan 3">
        </div>
    </div>

    <!-- Kategori Menu -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex space-x-4">
            <button class="category-button px-4 py-2 border rounded" onclick="setActive('Makanan'); window.location.href='/order/makanan'">Makanan</button>
            <button class="category-button px-4 py-2 border rounded" onclick="setActive('Minuman'); window.location.href='/order/minuman'">Minuman</button>
            <button class="category-button bg-yellow-400 px-4 py-2 rounded" onclick="setActive('Cemilan'); window.location.href='/order/cemilan'">Cemilan</button>
        </div>
    </div>

    <!-- Garis panjang -->
    <div class="border-t-2 border-gray-300 my-4"></div>

    <!-- Pencarian -->
    <div class="container mx-auto px-4 flex justify-between items-center mt-4">
        <input type="text" id="search" onkeyup="searchMenu()" placeholder="Cari menu..." class="w-1/3 p-2 border rounded">
        <button class="bg-yellow-400 text-black px-4 py-2 rounded">Pesanan Saya</button>
    </div>

    <!-- Daftar Menu -->
    <div class="container mx-auto px-4 py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 flex-grow">
    <script>
        let menuContainer = document.querySelector(".container.grid");

        let filteredItems = menuItems.filter(item => item.category === "Cemilan");

        filteredItems.forEach(item => {
            let menuHTML = `
                <div class="menu-item bg-white p-4 shadow rounded-xl flex items-center border border-black h-32">
                    <img src="${item.img}" class="h-16 w-16 object-cover rounded-lg" alt="${item.name}">
                    <div class="ml-4 flex-1">
                        <h3 class="font-bold text-lg">${item.name}</h3>
                        <p class="text-sm text-gray-600">${item.desc}</p>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-sm">Stok: ${item.stock}</p>
                            <p class="text-sm font-semibold">Harga: ${item.price}</p>
                        </div>
                    </div>
                    <button class="ml-4 bg-yellow-400 px-5 py-3 rounded-full flex items-center justify-center text-xl font-bold border border-black">+</button>
                </div>`;
            menuContainer.innerHTML += menuHTML;
        });
    </script>
    </div>
</body>
</html>