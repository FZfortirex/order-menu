<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Desktop</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .bg-maroon { background-color: #601B16; }
    body, html { height: 100%; margin: 0; padding: 0; }
  </style>
</head>
<body class="flex flex-col min-h-screen bg-white font-sans">

  <!-- Navbar -->
  @include('partials.navbar')

  <!-- Back dan Judul -->
  <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50 shadow-sm">
    <a href="{{ url('/menu') }}" class="text-sm font-medium text-maroon hover:underline flex items-center">
      &#x2190; <span class="ml-1">Back</span>
    </a>
    <span class="text-base font-bold text-gray-700">Profile</span>
    <div class="w-12"></div> <!-- spacer -->
  </div>

  <!-- Konten Utama -->
  <main class="flex-grow flex flex-col px-6 sm:px-12 py-10">
    <div class="flex flex-col sm:flex-row border rounded-lg overflow-hidden shadow-lg">

      <!-- Kolom Kiri -->
      <div class="bg-maroon text-white w-full sm:w-1/3 flex flex-col items-center justify-center p-8 space-y-4">
        <div class="w-24 h-24 rounded-full bg-black text-white flex items-center justify-center text-3xl font-bold shadow-md">
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
          <div class="text-sm text-gray-300 text-center">
            Nomer Telepon: <br> {{ $user->number_phone ?? 'Belum terisi' }}
          </div>
          <div class="text-sm text-gray-300 text-center">
            Email: <br> {{ $user->email ?? 'Belum terisi' }}
          </div>
        @endif
        <a href="{{ route('logoutAccount') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          class="mt-4 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-5 py-2 rounded transition-all duration-300">
          Ganti Akun
        </a>

        <form id="logout-form" action="{{ route('logoutAccount') }}" method="POST" class="hidden">
          @csrf
        </form>
      </div>

      <!-- Kolom Kanan -->
      <div class="bg-white w-full sm:w-2/3 p-10 flex flex-col justify-start border-l">
        <!-- Bagian Poin -->
        @if (!is_numeric($user->name))
          <div class="flex justify-end items-center">
            <a href="/tukarpoin" class="text-sm bg-maroon hover:bg-[#4f1410] text-white px-4 py-2 rounded transition-all duration-300 flex items-center">
              Tukar Poin <span class="ml-2 text-lg">➤</span>
            </a>
          </div>
        @endif

        <!-- Bagian History atau Info Fitur -->
        @if (!is_numeric(Auth::user()->name))
        <hr class="mt-6 border-gray-300" />
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Pembelian</h2>

            <ul class="space-y-4 max-h-72 overflow-y-auto pr-2">
              @forelse ($orders as $order)
                <li class="border p-4 rounded-md hover:bg-gray-50 transition">
                  <a href="/riwayat/{{ $order->id }}" class="flex justify-between items-center w-full">
                      <div>
                          <div class="font-medium text-gray-800">Pesanan Selesai</div>
                          <div class="text-sm text-gray-500">
                              Waktu Pesanan: {{ \Carbon\Carbon::parse($order->updated_at)->translatedFormat('d F Y H:i') }}
                          </div>
                      </div>
                      <div class="text-maroon font-semibold">
                          Rp{{ number_format($order->total_price, 0, ',', '.') }}
                      </div>
                  </a>
                </li>
              @empty
                <li class="text-sm text-gray-500">Belum ada riwayat pembelian.</li>
              @endforelse
            </ul>
          @else
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Beberapa fitur jika sudah punya Akun</h2>
            <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600">
              <li>Setiap pembelian akan mendapatkan poin yang bisa ditukar dengan voucher diskon.</li>
              <li>Riwayat pembelian Anda akan disimpan agar mudah dilihat kembali.</li>
            </ul>
          @endif
        </div>
  </main>

  <!-- Footer -->
  @include('partials.footer')

</body>
</html>
