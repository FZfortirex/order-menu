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
    <div class="flex flex-col items-center justify-center h-screen text-center p-4">
        <h1 class="text-md font-bold">Selamat Datang di</h1>
        <h2 class="text-3xl font-extrabold text-yellow-400">KAMPOENG SAWAH</h2>
        <p class="mt-3 text-sm max-w-sm">
            Nikmati pengalaman kuliner terbaik dengan sistem pemesanan langsung!
        </p>
        <a href="{{ auth()->check() ? route('order.menu') : route('loginTable.show') }}">
            <button class="bg-yellow-400 text-[#731b0c] px-4 py-2 mt-5 rounded-full font-bold btn-hover">
                Lihat Menu
            </button>
        </a>
    </div>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>