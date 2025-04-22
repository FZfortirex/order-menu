<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .active-category {
      background-color: #facc15;
      border: none;
    }
  </style>
</head>
<div class="p-4 bg-white min-h-screen">
  <a href="{{ url('/menu') }}" class="text-black text-lg font-semibold flex items-center mb-4">
    <i class="fas fa-arrow-left mr-2"></i> BACK
  </a>

  <!-- Gambar -->
  <img src="/images/{{ $menu->image }}" class="w-full rounded-xl mb-4" alt="{{ $menu->name }}">

  <!-- Nama dan Review -->
  <div class="flex justify-between items-center mb-2">
    <h1 class="text-xl font-bold">{{ $menu->name }}</h1>
    <span class="text-blue-500 text-xs border rounded-full px-2 py-1 flex items-center">
      <i class="fas fa-star mr-1"></i> Reviews
    </span>
  </div>

  <!-- Deskripsi -->
  <p class="text-gray-600 text-sm mb-4">{{ $menu->desc }}</p>

  <!-- Packaging -->
  <p class="text-sm font-semibold">Packaging</p>
  <label class="flex items-center space-x-2 text-sm my-1">
    <input type="checkbox"> <span>Dibungkus</span>
  </label>
  <label class="flex items-center space-x-2 text-sm mb-3">
    <input type="checkbox"> <span>Makan di tempat</span>
  </label>

  <!-- Catatan -->
  <div class="mb-4">
    <p class="text-sm font-semibold">Catatan <span class="text-gray-400 font-normal">(Opsional)</span></p>
    <p class="text-xs text-gray-500 mb-1">Contoh: tambahkan sedikit sambal saja</p>
    <textarea class="w-full border rounded-lg p-2 text-sm" rows="3" placeholder="Tulis catatan di sini..."></textarea>
  </div>

  <!-- Jumlah & Harga -->
  <div class="flex items-center justify-between mb-4">
    <p class="text-sm">{{ $menu->name }}</p>
    <div class="flex items-center space-x-4">
      <button onclick="updateQty(-1)" class="text-xl bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center">➖</button>
      <span id="qty" class="text-base font-semibold">1</span>
      <button onclick="updateQty(1)" class="text-xl bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center">➕</button>
    </div>
  </div>

  <!-- Tombol Tambah -->
  <button class="bg-yellow-400 text-black rounded-xl w-full py-3 font-semibold flex items-center justify-between px-4">
    Tambahkan : <span id="totalPrice">{{ $menu->price }}rb</span> <i class="fas fa-shopping-cart"></i>
  </button>

  <!-- Menu lainnya -->
  <div class="mt-10">
    <h3 class="text-lg font-semibold mb-4">Menu Lainnya</h3>
    <div class="grid grid-cols-1 gap-4">
      @foreach($menus as $m)
      <a href="{{ route('menu.detail', $m->id) }}" class="border rounded-xl shadow hover:shadow-md transition duration-200 bg-white overflow-hidden">
        <img src="/images/{{ $m->image }}" class="w-full h-36 object-cover" alt="{{ $m->name }}">
        <div class="p-2">
          <p class="font-semibold text-sm">{{ $m->name }}</p>
          <p class="text-xs text-gray-500">{{ $m->price }}rb</p>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</div>

<script>
  let qty = 1;
  const price = {{ $menu->price }};

  function updateQty(change) {
    qty += change;
    if (qty < 1) qty = 1;
    document.getElementById('qty').innerText = qty;
    document.getElementById('totalPrice').innerText = (qty * price) + 'rb';
  }
</script>
