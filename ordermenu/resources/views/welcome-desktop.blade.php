<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Kampoeng Sawah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #5b130a;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <div class="flex items-center justify-center h-screen text-center">
        <div class="container mx-auto p-6">
            <h1 class="text-lg font-bold">Selamat Datang di</h1>
            <h2 class="text-4xl md:text-6xl font-extrabold text-yellow-400">KAMPOENG SAWAH</h2>
            <p class="mt-4 text-lg max-w-xl mx-auto">
                Nikmati pengalaman kuliner terbaik dengan pelayanan modern dan cepat!
            </p>
            <a href="{{ auth()->check() ? route('order.menu') : route('loginTable.show') }}">
                <button class="bg-yellow-400 text-[#731b0c] px-6 py-2 mt-6 rounded-full font-bold btn-hover">
                    Lihat Menu
                </button>
            </a>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
