<!-- resources/views/user/galeri-mobile.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Tempat (Mobile)</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    @include('partials.navbar')
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4 text-center">Galeri Tempat (Mobile)</h1>

        {{-- KOTAK UPLOAD --}}
        @include('partials.upload-box')

        <div class="grid grid-cols-2 gap-4">
            @forelse($galeri as $foto)
                <div class="rounded overflow-hidden shadow bg-white">
                    <img class="w-full h-32 object-cover" src="{{ asset('storage/galeri/' . $foto->nama_file) }}" alt="Foto Tempat">
                    <div class="px-2 py-1">
                        <p class="text-xs text-gray-700">{{ $foto->deskripsi }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500">Belum ada foto yang diunggah.</p>
            @endforelse
        </div>
    </div>
<!-- Footer -->
@include('partials.footer')
</body>
</html>
