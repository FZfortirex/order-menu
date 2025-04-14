<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Tempat (Desktop)</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<!-- Navbar -->
@include('partials.navbar')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Galeri Tempat</h1>

        {{-- KOTAK UPLOAD --}}
        @include('partials.upload-box')

        {{-- Galeri --}}
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
                <p class="col-span-4 text-center text-gray-500">Belum ada foto yang diunggah.</p>
            @endforelse
        </div>
    </div>
<!-- Footer -->
@include('partials.footer')
</body>
</html>
