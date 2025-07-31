<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Galeri Tempat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Animasi zoom */
    .zoom-enter { transform: scale(0.7); opacity: 0; }
    .zoom-enter-active { transform: scale(1); opacity: 1; transition: transform 0.3s ease, opacity 0.3s ease; }
    .zoom-exit { transform: scale(1); opacity: 1; }
    .zoom-exit-active { transform: scale(0.7); opacity: 0; transition: transform 0.3s ease, opacity 0.3s ease; }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-white min-h-screen flex flex-col">

  <!-- Navbar -->
  @include('partials.navbar')

  <!-- Main Content -->
  <main class="flex-grow">
    <div class="container mx-auto px-4 py-12">

      <!-- Judul -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Galeri Tempat</h1>
        <div class="w-28 h-1 bg-yellow-400 mx-auto mt-2 rounded-full"></div>
        <p class="mt-2 text-gray-500 text-sm">Lihat momen dan suasana terbaik di Kampoeng Sawah</p>
      </div>

      <!-- Foto Statis -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
        @foreach([
          'foto-tempat1.png','foto-tempat2.png','foto-tempat3.png','foto-tempat4.png',
          'kmsawah.jpg','kmsawah2.jpeg','kmsawah3.jpeg','kmsawah4.jpg',
          'kmsawah5.jpg','kmsawah6.jpg','kmsawah7.jpg','kmsawah8.webp','kmsawah9.jpg'
        ] as $img)
          <div class="overflow-hidden rounded-2xl shadow-md group relative bg-white cursor-pointer">
            <img src="{{ asset('images/' . $img) }}" alt="Tempat" class="w-full h-60 object-cover transform group-hover:scale-105 transition duration-300 lightbox-trigger">
          </div>
        @endforeach
      </div>

      <!-- Galeri dari Database -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galeri as $foto)
          <div class="relative bg-white rounded-2xl overflow-hidden shadow-md group transition hover:shadow-xl cursor-pointer">
            <img src="{{ asset('storage/galeri/' . $foto->nama_file) }}" alt="Foto Galeri" class="w-full h-60 object-cover transform group-hover:scale-105 transition duration-300 lightbox-trigger">

            <!-- Tombol hapus -->
            <div class="absolute top-3 right-3 z-10">
              <form action="{{ route('galeri.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1
                    1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0
                    01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0
                    01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
              </form>
            </div>

            <!-- Deskripsi -->
            <div class="px-4 py-3 bg-gray-50">
              <p class="text-sm text-gray-600">{{ $foto->deskripsi }}</p>
            </div>
          </div>
        @empty

        @endforelse
      </div>

    </div>
  </main>

  <!-- Lightbox Modal -->
  <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center hidden z-50">
    <img id="lightbox-img" src="" alt="Preview" class="max-w-4xl max-h-[80vh] rounded-lg shadow-lg">
  </div>

  <script>
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');

    document.querySelectorAll('.lightbox-trigger').forEach(img => {
      img.addEventListener('click', () => {
        lightboxImg.src = img.src;
        lightbox.classList.remove('hidden');
        lightboxImg.classList.add('zoom-enter-active');
      });
    });

    lightbox.addEventListener('click', () => {
      lightbox.classList.add('hidden');
      lightboxImg.classList.remove('zoom-enter-active');
    });
  </script>

  <!-- Footer -->
  @include('partials.footer')

</body>
</html>