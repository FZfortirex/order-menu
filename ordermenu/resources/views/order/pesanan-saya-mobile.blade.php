@extends('simple')

@section('content')
<div class="container mx-auto px-4 py-6 font-[Poppins] grid grid-cols-1 gap-6 md:grid-cols-3">

  <!-- Kembali & Judul -->
  <div class="md:col-span-3 flex items-center justify-between">
    <a href="/menu" class="flex items-center text-base font-medium text-black hover:text-gray-700">
      <span class="text-xl mr-1">←</span> BACK
    </a>
    <h2 class="text-lg md:text-2xl font-bold">Pesanan Saya</h2>
  </div>

  <!-- Daftar Pesanan -->
  <div class="md:col-span-2 space-y-3">
    @forelse($pesanan as $item)
      <div class="relative flex items-start border rounded-lg p-3 bg-white shadow-sm hover:shadow-md transition">
        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-14 h-14 rounded object-cover mr-3">
        <div class="flex-1 text-sm space-y-1">
          <h3 class="font-semibold text-sm">{{ $item['name'] }}</h3>
          <p class="text-gray-600">{{ $item['desc'] ?? 'Harga: ' . $item['total_price'] }}</p>
          <p class="text-gray-500">Jumlah: {{ $item['quantity'] ?? 1 }}</p>
          <p class="text-xs text-gray-400 italic">Packaging: {{ $item['packaging'] ?? '-' }}</p>
          <p class="text-xs text-gray-400 italic">Catatan: {{ $item['note'] ?? '-' }}</p>
        </div>
        @if ($status === null || $status === 'selesai')
          <form method="POST" action="{{ route('pesanan.remove', $item['name']) }}">
            @csrf
            <button type="submit" class="absolute top-1 right-1 text-red-600 hover:text-red-800" title="Hapus">
              <span class="text-lg">&times;</span>
            </button>
          </form>
        @endif
      </div>
    @empty
      <p class="text-sm text-gray-500">Belum ada pesanan.</p>
    @endforelse
  </div>

  <!-- Detail Pemesanan -->
  <div class="bg-white border rounded-lg shadow-sm p-4 text-sm">
    <form action="{{ in_array($status, [null, 'selesai']) ? route('pesanan.submit') : ($status === 'menunggu' ? route('pesanan.cancel', $order->id) : '#') }}" method="POST" class="space-y-3">
      @csrf
      <div>
        <label class="block font-medium">Meja</label>
        @php
          $userNameIsNumber = Auth::check() && is_numeric(Auth::user()->name);
          $mejaValue = $userNameIsNumber ? Auth::user()->name : old('table', $order->table ?? '');
        @endphp
        <input type="number" name="meja" value="{{ $mejaValue }}" placeholder="Contoh: 4"
          class="w-full mt-1 px-3 py-2 border rounded focus:ring-yellow-400"
          {{ $userNameIsNumber || in_array($status, ['menunggu', 'sedang dibuat', 'sudah dibuat']) ? 'readonly' : '' }}>
      </div>

      <div>
        <label class="block font-medium">Voucher</label>
        @if ($status === 'menunggu' || $status === 'sedang dibuat' || $status === 'sudah dibuat')
          <div class="mt-1 px-3 py-2 border rounded bg-gray-50">🎫 {{ optional(optional($order->userDiscount)->reward)->name ?? '-' }}</div>
        @else
          <div class="relative">
            <select id="voucherSelect" name="voucher"
              class="w-full appearance-none px-3 py-2 border rounded focus:ring-yellow-400">
              <option value="">Pilih Voucher</option>
              @foreach ($vouchers as $voucher)
                <option value="{{ $voucher->reward->name }}" data-diskon="{{ $voucher->reward->value ?? 0 }}"
                  {{ old('voucher', optional(optional($order->userDiscount)->reward)->name ?? '') == $voucher->reward->name ? 'selected' : '' }}>
                  {{ $voucher->reward->name }}
                </option>
              @endforeach
            </select>
          </div>
        @endif
      </div>

      <div class="pt-2 border-t">
        <h4 class="font-medium mb-2">Ringkasan</h4>
        @foreach($pesanan as $item)
          <div class="flex justify-between">
            <span>{{ $item['name'] }} x {{ $item['quantity'] ?? 1 }}</span>
            <span>Rp. {{ number_format($item['items_price'] ?? 0) }}</span>
          </div>
        @endforeach
        <div class="flex justify-between font-semibold border-t pt-2">
          <span>Total :</span>
          <div class="flex-col" id="discountDetail" style="display:none;"></div>
          <span id="totalPriceFix">
            @if ($status === 'menunggu' || $status === 'sedang dibuat' || $status === 'sudah dibuat')
              Rp. {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
            @else
              Rp. {{ number_format($total ?? 0, 0, ',', '.') }}
            @endif
            @if (in_array($status, ['menunggu', 'sedang dibuat', 'sudah dibuat']) && optional(optional($order->userDiscount)->reward)->name)
              <small class="text-green-600">({{ optional(optional($order->userDiscount)->reward)->name }})</small>
            @endif
          </span>
          <input type="hidden" name="final_total" id="finalTotalInput"
            value="{{ $status === 'menunggu' ? ($order->total_price ?? 0) : $total }}">
        </div>
      </div>

      @if($status === null || $status === 'selesai')
        <button type="submit"
          class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 rounded transition">
          Pesan Sekarang
        </button>
      @elseif($status === 'menunggu')
        <button type="submit"
          class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 rounded transition">
          Batalkan Pesanan
        </button>
      @else
        <button type="button"
          class="w-full bg-gray-300 text-gray-700 font-semibold py-2 rounded cursor-not-allowed" disabled>
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

    voucherSelect?.addEventListener("change", function () {
      const selectedOption = voucherSelect.options[voucherSelect.selectedIndex];
      const discountPercent = parseFloat(selectedOption.getAttribute("data-diskon")) || 0;

      let newTotal = totalValue;
      if (discountPercent > 0) {
        newTotal = totalValue - (totalValue * discountPercent / 100);
        discountDetail.style.display = "block";
        discountDetail.innerHTML = `
          <span class="text-green-600">Diskon ${discountPercent}%: Rp. ${new Intl.NumberFormat('id-ID').format(newTotal)}</span>
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
