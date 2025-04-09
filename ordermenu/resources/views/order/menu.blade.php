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
            let activeCategory = localStorage.getItem("activeCategory") || "Semua";
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
            <img src="paket-ayam.png" class="w-full rounded-lg" alt="Paket Ayam">
            <img src="paket-nila.png" class="w-full rounded-lg" alt="Paket Nila">
            <img src="paket-ikan.png" class="w-full rounded-lg" alt="Paket Ikan">
        </div>
    </div>

    <!-- Kategori Menu -->
    <div class="container mx-auto px-4 py-4">
        <div class="flex space-x-4">
            <button class="category-button bg-yellow-400 px-4 py-2 rounded" onclick="setActive('Semua'); window.location.href='/'">Semua</button>
            <button class="category-button px-4 py-2 border rounded" onclick="setActive('Makanan'); window.location.href='/order/makanan'">Makanan</button>
            <button class="category-button px-4 py-2 border rounded" onclick="setActive('Minuman'); window.location.href='/order/minuman'">Minuman</button>
            <button class="category-button px-4 py-2 border rounded" onclick="setActive('Cemilan'); window.location.href='/order/cemilan'">Cemilan</button>
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
        <div class="menu-item bg-white p-4 shadow rounded-xl flex items-center border border-black h-32">
            <img src="ayam-geprek.png" class="h-16 w-16 object-cover rounded-lg" alt="Ayam Geprek">
            <div class="ml-4 flex-1">
                <h3 class="font-bold text-lg">Ayam Geprek</h3>
                <p class="text-sm text-gray-600">Ayam Goreng dengan Geprekan khasnya</p>
                <div class="flex justify-between items-center mt-2">
                    <p class="text-sm">Stok: 10</p>
                    <p class="text-sm font-semibold">Harga: 10rb</p>
                </div>
            </div>
            <button class="ml-4 bg-yellow-400 px-5 py-3 rounded-full flex items-center justify-center text-xl font-bold border border-black">+</button>
        </div>
    </div>

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
</body>
</html>
