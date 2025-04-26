<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Buat Akun Pelanggan</h2>

        @if(session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Pembuatan Akun -->
        <form action="{{ route('create-accounts.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Nama</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md" placeholder="Nama pelanggan" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kode_akses" class="block text-gray-700 font-semibold">Kode Akses</label>
                <input type="text" name="kode_akses" id="kode_akses" class="w-full px-4 py-2 border rounded-md" placeholder="Kode akses pelanggan" required>
                @error('kode_akses')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition duration-200">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
