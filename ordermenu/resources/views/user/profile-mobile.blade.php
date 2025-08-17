<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Mobile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-maroon { background-color: #601B16; }
  </style>
</head>
<body class="flex flex-col min-h-screen bg-white font-sans">

  <!-- Navbar -->
  @include('partials.navbar')

  <!-- Back & Title -->
  <div class="flex justify-between items-center px-4 py-3 border-b bg-gray-50 shadow-sm">
    <a href="{{ url('/menu') }}" class="text-sm font-medium text-maroon hover:underline flex items-center">
      &#x2190; <span class="ml-1">Back</span>
    </a>
    <span class="text-base font-bold text-gray-700">Profile</span>
    <div class="w-8"></div>
  </div>

  <!-- Main Content -->
  <main class="flex-grow px-4 py-6 space-y-6">

    <!-- Profile Card -->
    <div class="bg-maroon text-white rounded-lg p-6 flex flex-col items-center space-y-3">
      <div class="w-20 h-20 rounded-full bg-black flex items-center justify-center text-3xl font-bold">
        {{ strtoupper(substr($user->name, 0, 1)) }}
      </div>
      <div class="text-lg font-semibold text-center">
        @if (is_numeric($user->name))
          Meja {{ $user->name }}
        @else
          {{ $user->name }}
        @endif
      </div>

      @if (!is_numeric($user->name))
        <div class="text-xs text-gray-300 text-center">
          📞 {{ $user->number_phone ?? 'Belum terisi' }}
        </div>
        <div class="text-xs text-gray-300 text-center">
          ✉ {{ $user->email ?? 'Belum terisi' }}
        </div>
      @endif

      <a href="{{ route('logoutAccount') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="mt-2 w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2 rounded">
        Ganti Akun
      </a>
      <form id="logout-form" action="{{ route('logoutAccount') }}" method="POST" class="hidden">
        @csrf
      </form>
    </div>

    <!-- Tukar Poin -->
    @if (!is_numeric($user->name))
    <a href="/tukarpoin" class="block w-full text-center bg-maroon hover:bg-[#4f1410] text-white py-2 rounded font-medium">
      Tukar Poin ➤
    </a>
    @endif

    <!-- History -->
    <div>
      @if (!is_numeric(Auth::user()->name))
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Riwayat Pembelian</h2>
        <ul class="space-y-3 max-h-64 overflow-y-auto">
          @forelse ($orders as $order)
            <li class="border p-3 rounded-md hover:bg-gray-50 transition">
              <a href="/riwayat/{{ $order->id }}" class="flex justify-between items-center">
                <div>
                  <div class="font-medium text-gray-800">Pesanan Selesai</div>
                  <div class="text-xs text-gray-500">
                    {{ \Carbon\Carbon::parse($order->updated_at)->translatedFormat('d F Y H:i') }}
                  </div>
                </div>
                <div class="text-maroon font-semibold text-sm">
                  Rp{{ number_format($order->total_price, 0, ',', '.') }}
                </div>
              </a>
            </li>
          @empty
            <li class="text-sm text-gray-500">Belum ada riwayat pembelian.</li>
          @endforelse
        </ul>
      @else
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Keuntungan Punya Akun</h2>
        <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
          <li>Dapat poin setiap pembelian.</li>
          <li>Riwayat pembelian tersimpan.</li>
        </ul>
      @endif
    </div>
  </main>

  <!-- Footer -->
  @include('partials.footer')

</body>
</html>