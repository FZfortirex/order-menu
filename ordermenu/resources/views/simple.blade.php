<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Pesanan Saya')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-black">
  @yield('content')

  <!-- Footer -->
  <footer class="bg-black text-white mt-10 py-6">
    <div class="text-center space-x-4">
      <a href="#" class="hover:underline">Home</a>
      <a href="#" class="hover:underline">Galeri</a>
      <a href="#" class="hover:underline">Kontak</a>
      <a href="#" class="hover:underline">Opsi</a>
    </div>
    <div class="text-center mt-2 text-sm">© 2025 kampoengsawahproject</div>
  </footer>
</body>
</html>