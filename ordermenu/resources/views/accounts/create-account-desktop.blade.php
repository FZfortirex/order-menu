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
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Buat Akun Pelanggan</h2>

        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Pembuatan Akun -->
        <form action="{{ route('create-accounts.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Nama / Nomor Meja</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-md" placeholder="Nama pelanggan / Nomor Meja" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-md" placeholder="Email pelanggan">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="number_phone" class="block text-gray-700 font-semibold">Nomor HP</label>
                <input type="text" name="number_phone" id="number_phone" class="w-full px-4 py-2 border rounded-md" placeholder="08xxxxxxxxxx">
                @error('number_phone')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-md" placeholder="Password pelanggan">
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Role -->
            <input type="hidden" name="role" value="customer">

            <div class="flex justify-center mt-6">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow transition duration-200">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
