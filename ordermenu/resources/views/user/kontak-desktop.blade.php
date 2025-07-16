<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kontak</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body class="bg-red-900 text-white flex flex-col min-h-screen">

  <!-- Navbar -->
  @include('partials.navbar')

  <!-- Konten Utama -->
  <main class="flex-grow">
    <div class="max-w-4xl mx-auto p-8">
      <h1 class="text-3xl font-bold mb-6">KONTAK</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Form -->
        <form method="POST" action="{{ route('kontak.store') }}" class="space-y-4">
          @csrf
          <input type="text" name="name" placeholder="Nama Anda" class="w-full p-3 rounded-md bg-red-700 text-white" />
          <input type="text" name="number_phone" placeholder="No. Telp" class="w-full p-3 rounded-md bg-red-700 text-white" />
          <input type="email" name="email" placeholder="Email" class="w-full p-3 rounded-md bg-red-700 text-white" />
          <textarea name="message" placeholder="Pesan Anda" class="w-full p-3 rounded-md bg-red-700 text-white h-32"></textarea>
          <button class="bg-yellow-500 text-black p-3 rounded-md font-bold">Submit</button>
        </form>

        <!-- Map -->
        <div>
          <h2 class="text-lg font-bold mb-2">Lokasi Kampoeng Sawah</h2>
          <div id="map" style="height: 300px;" class="rounded"></div>
          <p class="mt-4">Jam Operasional:</p>
          <p>Senin–Minggu: <span class="text-yellow-300">09:00–19:00</span></p>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  @include('partials.footer')

  <script>
    var map = L.map('map').setView([-6.865679899765911, 110.82454083667585], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([-6.865679899765911, 110.82454083667585]).addTo(map)
      .bindPopup('<b>Kampoeng Sawah</b><br />Alamat Kampoeng Sawah')
      .openPopup();
  </script>

</body>
</html>
