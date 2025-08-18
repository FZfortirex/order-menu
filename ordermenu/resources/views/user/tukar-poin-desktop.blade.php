<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tukar Poin - Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .bg-maroon { background-color: #601B16; }
  </style>
</head>
<body class="bg-white text-black font-sans">

  <!-- Navbar -->
  @include('partials.navbar')

  <div class="mx-6 mt-4">
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
        {{ session('error') }}
      </div>
    @endif
  </div>
  <!-- Header -->
  <header class="flex justify-between items-center px-6 py-4 border-b shadow-sm bg-gray-50">
    <a href="{{ url('/profile') }}" class="text-maroon text-sm font-semibold flex items-center hover:underline">
      &#x2190; <span class="ml-1">Back</span>
    </a>
    <h1 class="text-lg sm:text-xl font-bold text-gray-800">Tukar Poin</h1>
    <div class="w-10"></div>
  </header>

  <!-- Total Poin -->
  <section class="mx-6 mt-6 border rounded-lg shadow-md overflow-hidden flex flex-col sm:flex-row">
    <div class="bg-maroon text-white p-6 flex items-center justify-center text-4xl font-bold sm:w-32"></div>
    <div class="p-6 flex-1">
      <div class="flex justify-between items-start flex-wrap gap-4">
        <div>
          <h2 class="text-lg font-semibold">Total Poin Kamu</h2>
          <p class="text-2xl font-bold mt-1">{{ $user->my_points }} Poin</p>
        </div>
        <div class="mt-2 flex flex-col space-y-2">
          <a href="{{ route('my-discount.index') }}" class="text-green-700 text-sm font-medium hover:underline">Lihat Discount Saya &gt;</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Voucher List -->
  <section class="px-6 mt-8 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($rewards as $reward)
    @if(!is_numeric($user->name))
      <div class="border rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col items-center"> 
        <p class="text-center text-sm font-medium mb-1">{{ $reward->name }}</p>
        <span class="text-xs text-gray-500 mb-3">{{ $reward->points_required }} poin</span>
        <form action="{{ route('tukarpoin.store') }}" method="POST">
          @csrf
          <input type="hidden" name="reward_id" value="{{ $reward->id }}">
          <button type="submit" class="bg-yellow-400 text-black px-4 py-1 rounded w-full text-sm font-semibold hover:brightness-95">
            Tukar
          </button>
        </form>
      </div>
    @endif
  @endforeach


    <!-- Tambahkan kartu voucher lain jika perlu -->
  </section>


</body>
</html>
