
@section('content')
<div class="bg-gray-100 min-h-screen">
  {{-- Carousel --}}
  <div class="container mx-auto px-4 py-6 flex space-x-4 overflow-x-auto">
    <img src="/img/paket-ayam.png" class="w-1/3 rounded-xl shadow-md" alt="Paket Ayam">
    <img src="/img/paket-nila1.png" class="w-1/3 rounded-xl shadow-md" alt="Paket Nila">
    <img src="/img/paket-nila2.png" class="w-1/3 rounded-xl shadow-md" alt="Paket Nila 2">
  </div>

  {{-- Kategori + Search + Tombol Pesanan --}}
  <div class="container mx-auto px-4 flex items-center justify-between mb-4">
    <div class="flex space-x-2">
      <button class="category-button active-category">Ayam, Bebek, lainnya</button>
      <button class="category-button">Makanan</button>
      <button class="category-button">Minuman</button>
      <button class="category-button">Cemilan</button>
    </div>
    <div class="flex space-x-2">
      <input type="text" class="border rounded px-3 py-2" placeholder="Type here">
      <a href="/pesanan" class="bg-yellow-400 px-4 py-2 rounded text-black font-semibold">Pesanan Saya</a>
    </div>
  </div>

  {{-- Daftar Menu --}}
  <div class="container mx-auto px-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($menus as $menu)
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center border border-black h-32">
      <img src="/images/{{ $menu['image'] }}" class="h-16 w-16 rounded-lg object-cover" alt="{{ $menu['name'] }}">
      <div class="ml-4 flex-1">
        <h3 class="font-bold text-lg">{{ $menu['name'] }}</h3>
        <p class="text-sm text-gray-600">{{ $menu['desc'] }}</p>
        <div class="flex justify-between text-sm mt-2">
          <span>Stok: {{ $menu['stock'] }}</span>
          <div class="text-right">
            @if($menu['discount_price'])
              <div class="text-sm text-red-500 line-through italic">
                Rp{{ number_format($menu['price'], 0, ',', '.') }}
              </div>
              <div class="text-sm font-semibold text-black">
                Rp{{ number_format($menu['discount_price'], 0, ',', '.') }}
              </div>
            @else
              <div class="text-sm font-semibold text-black">
                Rp{{ number_format($menu['price'], 0, ',', '.') }}
              </div>
            @endif
          </div>
        </div>
      </div>
      <button class="ml-4 bg-yellow-400 px-4 py-2 rounded-full font-bold text-lg">+</button>
    </div>
    @endforeach
  </div>
</div>
@endsection
