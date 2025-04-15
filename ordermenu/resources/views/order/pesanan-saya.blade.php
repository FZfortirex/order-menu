@extends('simple')

@section('content')
<div class="container mx-auto px-6 py-8 font-[Poppins] grid grid-cols-1 md:grid-cols-3 gap-8">

  <!-- Kembali & Judul -->
  <div class="md:col-span-3 flex items-center justify-between">
    <a href="/menu" class="flex items-center text-lg font-semibold text-black hover:text-gray-700">
      <span class="text-2xl mr-2">←</span> BACK
    </a>
    <h2 class="text-2xl font-bold">Pesanan Saya</h2>
  </div>

  <!-- Daftar Pesanan -->
  <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
    @forelse($pesanan as $item)
      <div class="flex justify-between items-center border rounded-xl p-3 bg-white shadow-md hover:shadow-lg transition">
        <div class="flex items-center gap-3">
          <img src="{{ asset('img/' . strtolower(str_replace(' ', '-', $item['name'])) . '.png') }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-md object-cover">
          <div class="space-y-1">
            <h3 class="font-semibold text-base">{{ $item['name'] }}</h3>
            <p class="text-sm text-gray-600">{{ $item['desc'] ?? 'Harga: ' . $item['price'] }}</p>
          </div>
        </div>
        <div class="flex flex-col items-end justify-between h-full">
          <span class="font-semibold text-sm">x{{ $item['quantity'] }}</span>
          <form method="POST" action="{{ route('pesanan.remove', $item['name']) }}">
            @csrf
            <button type="submit" class="text-red-600 text-xl font-bold hover:text-red-800 rounded-full">
              <span class="bg-red-100 p-1 rounded-full">❗</span>
            </button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-sm text-gray-500">Belum ada pesanan.</p>
    @endforelse
  </div>

  <!-- Detail Pemesanan -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6">
    <form action="{{ route('pesanan.submit') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium">Meja</label>
        <input type="text" name="meja" placeholder="Contoh: 4" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-yellow-400" required>
      </div>

      <div>
        <label class="block text-sm font-medium">Catatan tambahan <span class="text-gray-500 text-xs">Opsional</span></label>
        <textarea name="catatan" rows="3" class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-yellow-400"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium">Voucher Waroeng Sawah</label>
        <div class="relative mt-1">
          <select name="voucher" class="w-full px-10 py-2 border rounded-md appearance-none focus:outline-none focus:ring-1 focus:ring-yellow-400">
            <option value="">Pilih Voucher</option>
            <option value="diskon10">Diskon 10%</option>
          </select>
          <div class="absolute top-2.5 left-3">
            <span class="text-yellow-500">🎫</span>
          </div>
        </div>
      </div>

      <div class="mt-4 border-t pt-4 space-y-2 text-sm">
        <h4 class="font-medium">Riwayat Pembayaran</h4>
        @php $total = 0; @endphp
        @foreach($pesanan as $item)
          @php
            $subtotal = preg_replace('/[^0-9]/', '', $item['price']) * $item['quantity'];
            $total += $subtotal;
          @endphp
          <div class="flex justify-between">
            <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
            <span>Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
          </div>
        @endforeach
        <div class="flex justify-between font-semibold pt-2 border-t">
          <span>Total Pembayaran :</span>
          <span>Rp. {{ number_format($total, 0, ',', '.') }}</span>
        </div>
      </div>

      <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded-md transition">Pesan Sekarang</button>
    </form>
  </div>
</div>
@endsection