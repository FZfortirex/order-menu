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
  <div class="bg-maroon text-white text-xs px-6 py-6 flex justify-between items-center">
    <div class="flex space-x-4">
      <a href="#">Home</a>
      <a href="#">Galeri</a>
    </div>
    <div class="text-center text-[10px] font-semibold tracking-widest">
      <img src="logo.png" alt="Logo" class="mx-auto h-6 mb-1" />
      Kampoeng Sawah
    </div>
    <div class="flex space-x-2 items-center">
      <a href="#">Kontak</a>
      <a href="#">Opsi <span class="inline-block rotate-180 text-sm">▾</span></a>
    </div>
  </div>

  <!-- Back dan Judul -->
  <div class="flex justify-between items-center px-6 py-6 border-b">
    <button class="text-sm font-medium flex items-center">
      <a href="{{ url('/menu') }}" class="text-base font-medium">&#x2190; BACK</a>
    </button>
    <span class="text-sm font-bold">Profile</span>
    <div></div>
  </div>

  <!-- Konten Utama -->
  <main class="flex-grow flex flex-col px-12 py-12">
    <div class="flex flex-col sm:flex-row flex-grow min-h-[calc(100vh-160px)] border rounded-lg overflow-hidden mt-4">
      <!-- Kolom Kiri -->
      <div class="bg-maroon text-white w-full sm:w-1/3 flex flex-col items-center justify-center p-8">
        <div class="w-24 h-24 rounded-full bg-gray-300 mb-6"></div>
        <div class="text-lg font-semibold">{{ strtoupper(substr($user->name, 0, 1)) }} </div>
        <div class="text-sm text-gray-300">Nomer Telephone</div>
        <div class="text-sm text-gray-300">Email</div>
      </div>

      <!-- Kolom Kanan -->
      <div class="bg-white w-full sm:w-2/3 p-10 flex flex-col justify-between border-l">
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-2">
            <div class="text-3xl font-bold">$</div>
            <div class="text-xl font-semibold">{{ $user->my_points }} poin</div>
          </div>
          <a href="#" class="text-sm text-white bg-maroon px-4 py-2 rounded flex items-center">
            Tukar Poin <span class="ml-2 text-lg">➤</span>
          </a>
        </div>
        <div class="text-2xl font-bold mt-8">20 poin</div>
        <hr class="mt-6 border-gray-300" />
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-black text-white text-center text-xs py-6">
    <img src="logo-mini.png" alt="Logo" class="mx-auto mb-1 h-6" />
    <div class="text-yellow-400 font-semibold mb-1">Kampoeng Sawah</div>
    <div class="flex justify-center space-x-4 mb-1">
      <a href="#">Home</a>
      <a href="#">Galeri</a>
      <a href="#">Kontak</a>
      <a href="#">Opsi</a>
    </div>
    <div class="text-gray-400 text-[10px]">© 2025 kampoengsawahsystem</div>
  </footer>

</body>
</html>
