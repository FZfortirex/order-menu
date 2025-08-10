<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-white min-h-screen font-sans text-gray-800">

  <div class="p-4 max-w-md mx-auto">
    <!-- Tombol Kembali -->
    <a href="{{ url('/menu') }}" class="text-black text-lg font-semibold flex items-center mb-4">
      <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <!-- Gambar Menu -->
    <img src="/images/{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full rounded-xl mb-4 shadow" />

    <!-- Nama Menu & Review -->
    <div class="flex justify-between items-center mb-2">
      <h1 class="text-xl font-bold tracking-wide">{{ $menu->name }}</h1>
      <a href="{{ route('menu.reviews', $menu->id) }}" class="text-blue-500 text-sm border rounded-full px-2 py-1 flex items-center hover:bg-blue-100 transition">
          <i class="fas fa-star mr-1"></i> Reviews
          </a>
      </span>
    </div>

    <!-- Deskripsi -->
    <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $menu->desc }}</p>

    <form action="{{ route('pesanan.add') }}" method="POST">
  @csrf
  <input type="hidden" name="menu_id" value="{{ $menu->id }}">
  <input type="hidden" name="price" value="{{ $menu->price }}">
  <input type="hidden" name="discount_price" value="{{ $menu->discount_price }}">
  <input type="hidden" id="quantity" name="quantity" value="1">

  <!-- Packaging -->
  <div class="mb-4">
    <p class="text-sm font-semibold mb-2">Packaging</p>
    <div class="flex flex-col gap-2 text-sm">
      <label class="inline-flex items-center gap-2">
        <input type="radio" name="packaging" value="dibungkus" class="accent-yellow-400" required />
        Dibungkus
      </label>
      <label class="inline-flex items-center gap-2">
        <input type="radio" name="packaging" value="makan di tempat" class="accent-yellow-400" required />
        Makan di tempat
      </label>
    </div>
  </div>

  <!-- Catatan -->
  <div class="mb-4">
    <p class="text-sm font-semibold">Catatan <span class="text-gray-400 font-normal">(Opsional)</span></p>
    <p class="text-xs text-gray-500 mb-1">Contoh: tambahkan sedikit sambal saja</p>
    <textarea name="note" rows="3" class="w-full border rounded-lg p-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="Tulis catatan di sini..."></textarea>
  </div>

  <!-- Jumlah & Harga -->
  <div class="flex items-center justify-between mb-4">
    <p class="text-base font-medium">Jumlah Pemesanan</p>
    <div class="flex items-center space-x-4">
      <button type="button" onclick="updateQty(-1)" class="text-xl bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-300">-</button>
      <span id="qty" class="text-base font-semibold">1</span>
      <button type="button" onclick="updateQty(1)" class="text-xl bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-300">+</button>
    </div>
  </div>

  <!-- Tombol Tambahkan -->
  @if(is_null($status) || $status === 'selesai')
    <button type="submit" class="bg-yellow-400 text-black rounded-xl w-full py-3 font-semibold flex items-center justify-between px-4 hover:bg-yellow-300 transition">
      Tambahkan:
      <span id="totalPrice">
        @if($menu->discount_price)
          Rp {{ number_format($menu->discount_price, 0, ',', '.') }}
        @else
          Rp {{ number_format($menu->price, 0, ',', '.') }}
        @endif
      </span>
      <i class="fas fa-shopping-cart"></i>
    </button>
  @else
    <button type="button" class="w-full bg-gray-300 text-gray-700 font-semibold py-3 rounded-md cursor-not-allowed" disabled>
      Batalkan Pesanan Dulu
    </button>
  @endif
</form>


    <!-- Menu Lainnya -->
    <div class="mt-10">
      <h3 class="text-lg font-semibold mb-4">Menu Lainnya</h3>
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        @foreach($menus as $m)
        <a href="{{ route('menu.detail', $m->id) }}" class="border rounded-xl shadow hover:shadow-md transition duration-200 bg-white overflow-hidden">
          <img src="/images/{{ $m->image }}" alt="{{ $m->name }}" class="w-full h-32 object-cover" />
          <div class="p-2">
            <p class="font-semibold text-sm truncate">{{ $m->name }}</p>
            <p class="text-xs text-gray-500">Rp {{ number_format($m->price, 0, ',', '.') }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>

  <script>
    let qty = 1;
    const price = {{ $menu->price }};
    const discountPrice = {{ $menu->discount_price ?? 'null' }};
    const unitPrice = discountPrice || price;

    function updateQty(change) {
      qty += change;
      if (qty < 1) qty = 1;
      document.getElementById('qty').innerText = qty;
      document.getElementById('quantity').value = qty;

      const total = qty * unitPrice;
      document.getElementById('totalPrice').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
  </script>

</body>
</html>
