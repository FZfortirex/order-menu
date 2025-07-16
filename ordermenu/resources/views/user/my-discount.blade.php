<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Discounts - Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-maroon { background-color: #601B16; }
  </style>
</head>
<body class="min-h-screen flex flex-col bg-white text-black font-sans">

  @include('partials.navbar')

  <header class="flex justify-between items-center px-6 py-4 border-b shadow-sm bg-gray-50">
    <a href="{{ url('/profile') }}" class="text-maroon text-sm font-semibold flex items-center hover:underline">
      &#x2190; <span class="ml-1">Back</span>
    </a>
    <h1 class="text-lg sm:text-xl font-bold text-gray-800">Voucher Saya</h1>
    <div class="w-10"></div>
  </header>

  <main class="mx-6 mt-6 flex-grow">
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    @if($userDiscountsGrouped && $userDiscountsGrouped->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($userDiscountsGrouped as $discountGroup)
        <div class="border rounded-lg p-4 shadow flex flex-col items-center">
            <p class="font-semibold mb-2 text-center text-lg">{{ $discountGroup->reward->name ?? 'Reward tidak ditemukan' }}</p>
            <p class="text-xs text-gray-500 mb-2">Jumlah : {{ $discountGroup->total }}</p>
            @if($discountGroup->order)
            <p class="text-xs text-gray-600">Order ID: {{ $discountGroup->order->id }}</p>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <p class="text-gray-600 text-center mt-10">Kamu belum memiliki voucher yang ditukar.</p>
    @endif
  </main>

  @include('partials.footer')

</body>
</html>
