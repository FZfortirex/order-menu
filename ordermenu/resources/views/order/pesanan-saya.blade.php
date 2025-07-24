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
      <div class="relative flex items-center border rounded-xl p-3 bg-white shadow-md hover:shadow-lg transition w-full max-h-[160px] overflow-hidden">
        <div class="flex items-center gap-3">
          <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-md object-cover">
          <div class="space-y-1">
            <h3 class="font-semibold text-base">{{ $item['name'] }}</h3>
            <p class="text-sm text-gray-600">{{ $item['desc'] ?? 'Harga: ' . $item['total_price'] }}</p>
            <p class="text-sm text-gray-600">Jumlah: {{ $item['quantity'] ?? 1 }}</p>
            <p class="text-xs text-gray-500 italic">Packaging: {{ $item['packaging'] ?? '-' }}</p>
            <p class="text-xs text-gray-500 italic">Catatan: {{ $item['note'] ?? '-' }}</p>
          </div>
        </div>
        @if ($status === null || $status === 'selesai')
          <form method="POST" action="{{ route('pesanan.remove', $item['name']) }}">
            @csrf
            <button type="submit" class="absolute top-2 right-2 text-red-600 text-xl font-bold hover:text-red-800 rounded-full" title="Hapus">
              <span class="bg-red-100 p-1 rounded-full">✖</span>
            </button>
          </form>
        @endif
      </div>
    @empty
      <p class="text-sm text-gray-500">Belum ada pesanan.</p>
    @endforelse
  </div>

  <!-- Detail Pemesanan -->
  <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6">
    <form
      action="{{ in_array($status, [null, 'selesai']) ? route('pesanan.submit') : ($status === 'menunggu' ? route('pesanan.cancel', $order->id) : '#') }}"
      method="POST"
      class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium">Meja</label>
        @php
          $userNameIsNumber = Auth::check() && is_numeric(Auth::user()->name);
          $mejaValue = $userNameIsNumber ? Auth::user()->name : old('table', $order->table ?? '');
        @endphp

        <input
          type="number"
          name="meja"
          value="{{ $mejaValue }}"
          placeholder="Contoh: 4"
          class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-yellow-400"
          {{ $userNameIsNumber || in_array($status, ['menunggu', 'sedang dibuat', 'sudah dibuat']) ? 'readonly' : '' }}>
      </div>
      <div>
        <label class="block text-sm font-medium">Catatan tambahan ( Opsional )</label>
        <textarea name="catatan" rows="3"
          class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-yellow-400"
          {{ in_array($status, ['menunggu', 'sedang dibuat', 'sudah dibuat']) ? 'readonly' : '' }}>{{ old('additional_note', $order->additional_note ?? '') }}</textarea>
      </div>
      <div>
      @if ($status === 'menunggu' || $status === 'sedang dibuat' || $status === 'sudah dibuat')
        <label class="block text-sm font-medium">Voucher Waroeng Sawah</label>
        <div class="mt-1 px-4 py-2 border rounded-md text-sm text-gray-700">
          🎫 {{ optional(optional($order->userDiscount)->reward)->name ?? '-' }}
        </div>
      @else
        <label class="block text-sm font-medium">Voucher Waroeng Sawah</label>
        <div class="relative mt-1">
          <select id="voucherSelect" name="voucher"
            class="w-full px-10 py-2 border rounded-md appearance-none focus:outline-none focus:ring-1 focus:ring-yellow-400"
            {{ $status !== null && $status !== 'selesai' ? 'disabled' : '' }}>
            <option value="">Pilih Voucher</option>
            @foreach ($vouchers as $voucher)
              <option value="{{ $voucher->reward->name }}"
                data-diskon="{{ $voucher->reward->value ?? 0 }}"
                {{ old('voucher', optional(optional($order->userDiscount)->reward)->name ?? '') == $voucher->reward->name ? 'selected' : '' }}>
                {{ $voucher->reward->name }}
              </option>
            @endforeach
          </select>
          <div class="absolute top-2.5 left-3">
            <span class="text-yellow-500">🎫</span>
          </div>
        </div>
      @endif
      </div>
      <div class="mt-4 border-t pt-4 space-y-2 text-sm">
        <h4 class="font-medium">Riwayat Pembayaran</h4>
        @foreach($pesanan as $item)
          <div class="flex justify-between">
            <span>{{ $item['name'] }} x {{ $item['quantity'] ?? 1 }}</span>
            <span>Rp. {{ number_format($item['items_price'] ?? 0) }}</span>
          </div>
        @endforeach
        <div class="flex justify-between font-semibold pt-2 border-t">
          <span>Total Pembayaran :</span>
          <div class="flex justify-between font-semibold text-yellow-600" id="discountDetail" style="display:none;">
            <!-- detail diskon -->
          </div>
          <span id="totalPriceFix">
            @if ($status === 'menunggu' || $status === 'sedang dibuat' || $status === 'sudah dibuat')
                Rp. {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
            @else
                Rp. {{ number_format($total ?? 0, 0, ',', '.') }}
            @endif

            @if (in_array($status, ['menunggu', 'sedang dibuat', 'sudah dibuat']) && optional(optional($order->userDiscount)->reward)->name)
              <small style="color: green;">({{ optional(optional($order->userDiscount)->reward)->name }})</small>
            @endif
          </span>
          <input type="hidden" name="final_total" id="finalTotalInput"
            value="{{ $status === 'menunggu' ? ($order->total_price ?? 0) : $total }}">
        </div>
      </div>

      @if($status === null || $status === 'selesai')
      <form action="{{ route('pesanan.submit') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded-md transition">
          Pesan Sekarang
        </button>
      </form>
    @elseif($status === 'menunggu')
      <form action="{{ route('pesanan.cancel', $currentOrderId) }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded-md transition">
          Batalkan Pesanan
        </button>
      </form>
    @else
      <button type="button" class="w-full bg-gray-300 text-gray-700 font-semibold py-2 rounded-md cursor-not-allowed" disabled>
        {{ ucfirst($status) }}
      </button>
    @endif
    </form>
  </div>
</div>
@endsection

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const voucherSelect = document.getElementById("voucherSelect");
    const totalValue = {{ $total }};
    const totalPriceFix = document.getElementById("totalPriceFix");
    const discountDetail = document.getElementById("discountDetail");
    const finalTotalInput = document.getElementById("finalTotalInput");

    voucherSelect.addEventListener("change", function () {
      const selectedOption = voucherSelect.options[voucherSelect.selectedIndex];
      const discountPercent = parseFloat(selectedOption.getAttribute("data-diskon")) || 0;

      let newTotal = totalValue;
      if (discountPercent > 0) {
        newTotal = totalValue - (totalValue * discountPercent / 100);
        discountDetail.style.display = "flex";
        discountDetail.innerHTML = `
          <span>${new Intl.NumberFormat('id-ID').format(totalValue)} - ${discountPercent}% = ${new Intl.NumberFormat('id-ID').format(newTotal)}</span>
        `;
      } else {
        discountDetail.style.display = "none";
        newTotal = totalValue;
      }

      totalPriceFix.textContent = "Rp. " + new Intl.NumberFormat('id-ID').format(newTotal);
      finalTotalInput.value = Math.round(newTotal);
    });
  });
</script>