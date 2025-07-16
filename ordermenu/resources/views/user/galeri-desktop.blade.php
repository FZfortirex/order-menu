<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Tempat (Desktop)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Konten utama -->
    <main class="flex-grow">
        <div class="container mx-auto p-6">
            <h1 class="text-3xl font-bold mb-6 text-center">Galeri Tempat</h1>
            
                    <!-- Foto Statis -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <img src="{{ asset('images/foto-tempat1.png') }}" alt="Tempat 1" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/foto-tempat2.png') }}" alt="Tempat 2" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/foto-tempat3.png') }}" alt="Tempat 3" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/foto-tempat4.png') }}" alt="Tempat 4" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah.jpg') }}" alt="Tempat 5" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah2.jpeg') }}" alt="Tempat 6" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah3.jpeg') }}" alt="Tempat 7" class="w-full aspect-square object-cover rounded shadow">
            <img src="{{ asset('images/kmsawah4.jpg') }}" alt="Tempat 8" class="w-full aspect-square object-cover rounded shadow">
        </div>




            <!-- Galeri dari Database -->
            <div class="grid grid-cols-4 gap-6">
                @forelse($galeri as $foto)
                    <div class="relative rounded overflow-hidden shadow bg-white">
                        <img class="w-full h-48 object-cover" src="{{ asset('storage/galeri/' . $foto->nama_file) }}" alt="Foto Tempat">
                        <div class="absolute top-2 right-2">
                            <form action="{{ route('galeri.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="px-4 py-2">
                            <p class="text-sm text-gray-700">{{ $foto->deskripsi }}</p>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
