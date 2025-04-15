@extends('layouts.app')

@section('content')
<div class="md:hidden p-4">
  <!-- Banner -->
  <div class="w-full overflow-hidden rounded-xl">
    <img src="/path/to/paket-ayam.png" alt="Paket Ayam" class="w-full object-cover rounded-xl">
  </div>

  <!-- Kategori & Filter -->
  <div class="flex flex-col gap-2 mt-4">
    <div class="flex gap-2 overflow-x-auto">
      <button class="category-button px-4 py-2 border rounded active-category" onclick="filterCategory('Semua')">Semua</button>
      <button class="category-button px-4 py-2 border rounded" onclick="filterCategory('Makanan')">Makanan</button>
      <button class="category-button px-4 py-2 border rounded" onclick="filterCategory('Minuman')">Minuman</button>
      <button class="category-button px-4 py-2 border rounded" onclick="filterCategory('Cemilan')">Cemilan</button>
    </div>
    <input type="text" id="search" onkeyup="searchMenu()" placeholder="Cari menu..." class="p-2 border rounded w-full">
  </div>

  <!-- Daftar Menu -->
  <div id="menu-container" class="mt-4 space-y-4"></div>

  <!-- Floating Icon -->
  <a href="{{ route('profile') }}" class="fixed bottom-20 right-4 bg-yellow-400 p-3 rounded-full border border-black shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.004 9.004 0 0112 15c2.072 0 3.98.707 5.465 1.898M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
  </a>

  <!-- Tombol Pesanan -->
  <a href="{{ route('pesanan') }}" class="fixed bottom-4 left-4 right-4 bg-yellow-400 text-center py-3 rounded-lg shadow-md text-black font-bold">
    Pesanan Saya
  </a>
</div>
@endsection
