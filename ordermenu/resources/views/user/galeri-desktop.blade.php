<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Galeri Tempat</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-white min-h-screen flex flex-col">

  <!-- Navbar -->
  @include('partials.navbar')

  <!-- Main Content -->
  <main class="flex-grow">
    <div class="container mx-auto px-4 py-12">

      <!-- Judul Halaman -->
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
          <div class="overflow-hidden rounded-2xl shadow-md group relative bg-white">
            <img src="{{ asset('images/' . $img) }}" alt="Tempat" class="w-full h-60 object-cover transform group-hover:scale-105 transition duration-300">
          </div>
        @endforeach
      </div>

      <!-- Galeri dari Database -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galeri as $foto)
          <div class="relative bg-white rounded-2xl overflow-hidden shadow-md group transition hover:shadow-xl">
            <img src="{{ asset('storage/galeri/' . $foto->nama_file) }}" alt="Foto Galeri" class="w-full h-60 object-cover transform group-hover:scale-105 transition duration-300">

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
          <p class="text-gray-500 col-span-4 text-center">Belum ada foto yang diunggah.</p>
        @endforelse
      </div>

    </div>
  </main>

  <!-- Footer -->
  @include('partials.footer')

</body>
</html>
