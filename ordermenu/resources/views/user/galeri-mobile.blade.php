<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Galeri Tempat </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials.navbar')

    <main class="flex-grow container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Galeri Tempat</h1>

        {{-- Foto Statis (2 kolom biar pas di mobile) --}}
        <div class="grid grid-cols-2 gap-4 mb-8">
            <img src="{{ asset('images/foto-tempat1.png') }}" alt="Tempat 1" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/foto-tempat2.png') }}" alt="Tempat 2" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/foto-tempat3.png') }}" alt="Tempat 3" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/foto-tempat4.png') }}" alt="Tempat 4" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah.jpg') }}" alt="Tempat 5" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah2.jpeg') }}" alt="Tempat 6" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah3.jpeg') }}" alt="Tempat 7" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah4.jpg') }}" alt="Tempat 8" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah5.jpg') }}" alt="Tempat 9" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah6.jpg') }}" alt="Tempat 10" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah7.jpg') }}" alt="Tempat 11" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah8.webp') }}" alt="Tempat 12" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah9.jpg') }}" alt="Tempat 13" class="w-full aspect-square object-cover rounded shadow">
        </div>

        {{-- Galeri dari Database (2 kolom) --}}
        <div class="grid grid-cols-2 gap-4">
            @forelse($galeri as $foto)
                <div class="rounded-lg overflow-hidden shadow-md bg-white hover:shadow-lg transition-shadow duration-300">
                    <img
                      class="w-full aspect-square object-cover"
                      src="{{ asset('storage/galeri/' . $foto->nama_file) }}"
                      alt="Foto Tempat"
                      loading="lazy"
                    >
                    <div class="px-3 py-2">
                        <p class="text-sm text-gray-700 truncate" title="{{ $foto->deskripsi }}">{{ $foto->deskripsi }}</p>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </main>

    <!-- Modal Fullscreen -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 hidden">
<img id="modalImage" src="" alt="Preview"
     class="w-auto h-auto max-w-[90vw] max-h-[70vh] rounded-lg shadow-lg mx-auto" />
  <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
</div>

<script>
  function openModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modalImg.src = src;
    modal.classList.remove('hidden');
  }

  function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
  }

  // Tambahkan event listener ke semua gambar
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("img").forEach((img) => {
      img.addEventListener("click", () => {
        openModal(img.src);
      });
    });
  });
</script>


    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
