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
<body class="bg-gray-100 font-sans antialiased">

  @include('partials.navbar')
  <div class="container mx-auto p-6 rounded-xl shadow-md mt-6">
    <a href="{{ url('/menu') }}" class="text-black text-lg font-semibold flex items-center mb-4">
      <i class="fas fa-arrow-left mr-2"></i> BACK
    </a>

    <div class="flex flex-col md:flex-row gap-8">
      <!-- Gambar -->
      <img src="/images/{{ $menu->image }}" class="md:w-1/2 w-full rounded-xl shadow" alt="{{ $menu->name }}">

      <!-- Detail -->
      <div class="md:w-1/2 w-full">
        <h2 class="text-2xl font-semibold flex items-center justify-between mb-2">
          {{ $menu->name }}
          <a href="{{ route('menu.reviews', $menu->id) }}" class="text-blue-500 text-sm border rounded-full px-2 py-1 flex items-center hover:bg-blue-100 transition">
          <i class="fas fa-star mr-1"></i> Reviews
          </a>
        </h2>
        <p class="text-gray-600 mb-4">{{ $menu->desc }}</p>

        <form action="{{ route('pesanan.add') }}" method="POST">
          @csrf
          <input type="hidden" name="menu_id" value="{{ $menu->id }}">
          <input type="hidden" name="price" value="{{ $menu->price }}">
          <input type="hidden" name="discount_price" value="{{ $menu->discount_price }}">
          <input type="hidden" id="quantity" name="quantity" value="1">
          <input type="hidden" id="stock" value="{{ $menu->stock }}">

          <p class="font-semibold">Packaging</p>
          <label class="flex items-center space-x-2 my-1">
            <input type="radio" name="packaging" value="dibungkus" required>
            <span>Dibungkus</span>
          </label>
          <label class="flex items-center space-x-2 mb-3">
            <input type="radio" name="packaging" value="makan di tempat" required>
            <span>Makan di tempat</span>
          </label>
          <p class="font-semibold flex justify-between items-center mt-4">
            Catatan <span class="text-gray-500 text-sm">Opsional</span>
          </p>
          <p class="text-sm text-gray-500 mb-1">Contoh: tambahkan sedikit sambal saja</p>
          <textarea name="note" class="w-full border rounded-lg p-2 mb-4" rows="3" placeholder="Tulis catatan di sini..."></textarea>
          <div class="flex items-center justify-between mb-2">
            <p class="text-base font-medium">Jumlah Pemesanan</p>
            <div class="flex items-center space-x-4">
              <button type="button" id="btn-minus" onclick="updateQty(-1)" class="text-xl bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center">➖</button>
              <span id="qty" class="text-lg font-semibold">1</span>
              <button type="button" id="btn-plus" onclick="updateQty(1)" class="text-xl bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center">➕</button>
            </div>
          </div>
          @if(is_null($status) || $status === 'selesai')
            <button type="submit" class="bg-yellow-400 text-black rounded-xl w-full py-2 font-semibold flex items-center justify-between px-4">
              Tambahkan :
              <span id="totalPrice" class="flex items-center space-x-2">
                @if($menu->discount_price)
                  <span class="text-red-600 line-through text-sm">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                  </span>
                  <span class="text-black font-bold">
                    Rp {{ number_format($menu->discount_price, 0, ',', '.') }}
                  </span>
                @else
                  <span class="text-black font-bold">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                  </span>
                @endif
              </span>
              <i class="fas fa-shopping-cart"></i>
            </button>
          @else
            <button type="button" class="w-full bg-gray-300 text-gray-700 font-semibold py-2 rounded-md cursor-not-allowed" disabled>
              Batalkan Pesanan Dulu
            </button>
          @endif
        </form>
        </div>
      </div>
    </div>

    <!-- Bagian Menu Lainnya -->
    <div class="mt-12">
      <h3 class="text-xl font-semibold mb-4">Menu Lainnya</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      @foreach($menus as $m)
  <a href="{{ route('menu.detail', $m->id) }}" class="border rounded-xl overflow-hidden shadow hover:shadow-lg transition duration-200 bg-white">
    <div class="aspect-[4/3] w-full overflow-hidden">
      <img src="/images/{{ $m->image }}" class="object-cover w-full h-full" alt="{{ $m->name }}">
    </div>
    <div class="p-3">
      <p class="font-semibold">{{ $m->name }}</p>
      <p class="text-sm text-gray-500">{{ $m->price }}rb</p>
    </div>
  </a>
@endforeach

      </div>
    </div>
  </div>

  @include('partials.footer')

  <script>
    let qty = 1;
    const price = {{ $menu->price }};
    const discountPrice = {{ $menu->discount_price ?? 'null' }};
    const unitPrice = discountPrice || price;

    function updateQty(change) {
      const stock = parseInt(document.getElementById('stock').value);
      const btnPlus = document.getElementById('btn-plus');
      const btnMinus = document.getElementById('btn-minus');

      let newQty = qty + change;

      if (newQty < 1) newQty = 1;
      if (newQty > stock) newQty = stock;

      qty = newQty;

      document.getElementById('qty').innerText = qty;
      document.getElementById('quantity').value = qty;

      const total = qty * unitPrice;
      document.getElementById('totalPrice').innerText = 'Rp ' + total.toLocaleString('id-ID');

      btnMinus.disabled = qty <= 1;
      btnPlus.disabled = qty >= stock;
    }

    document.addEventListener('DOMContentLoaded', () => updateQty(0));
  </script>
</body>
</html>
