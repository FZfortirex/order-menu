<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kampoeng Sawah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #731b0c;
            color: white;
            background-image: url('/background.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-xs sm:max-w-sm md:max-w-md bg-[#5b130a] bg-opacity-90 p-6 rounded-lg shadow-lg text-center">
    <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="mx-auto mb-4 h-12 sm:h-16">
        <h1 class="text-sm sm:text-lg font-bold">RUMAH MAKAN</h1>
        <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-yellow-400 mb-4">Kampoeng Sawah</h2>

        <form id="loginForm" class="space-y-3 sm:space-y-4">
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">👤</span>
                <input type="text" placeholder="Username" class="w-full pl-9 sm:pl-10 p-2 sm:p-3 rounded-md border border-gray-300 text-black text-sm sm:text-base" required>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm sm:text-base">#</span>
                <input type="password" placeholder="Kode Akses" class="w-full pl-9 sm:pl-10 p-2 sm:p-3 rounded-md border border-gray-300 text-black text-sm sm:text-base" required>
            </div>
            <button type="submit" class="w-full bg-yellow-400 text-[#731b0c] font-bold py-2 sm:py-3 rounded-md hover:bg-yellow-300">Login</button>
        </form>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault();
            window.location.href = "/welcome";
        });
    </script>
</body>
</html>
