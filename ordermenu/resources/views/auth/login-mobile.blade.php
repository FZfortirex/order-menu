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
    <div class="w-full max-w-xs bg-[#5b130a] bg-opacity-90 p-6 rounded-lg shadow-lg text-center">
        <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="mx-auto mb-4 h-16">
        <h1 class="text-sm font-bold">RUMAH MAKAN</h1>
        <h2 class="text-xl font-extrabold text-yellow-400 mb-4">Kampoeng Sawah</h2>

        <form id="loginFormMobile" class="space-y-3">
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">👤</span>
                <input type="text" placeholder="Username" class="w-full pl-9 p-2 rounded-md border border-gray-300 text-black text-sm" required>
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">🔒</span>
                <input type="password" placeholder="Kode Akses" class="w-full pl-9 p-2 rounded-md border border-gray-300 text-black text-sm" required>
            </div>
            <button type="submit" class="w-full bg-yellow-400 text-[#731b0c] font-bold py-2 rounded-md hover:bg-yellow-300">Login</button>
        </form>
    </div>

    <script>
        document.getElementById("loginFormMobile").addEventListener("submit", function(event) {
            event.preventDefault();
            window.location.href = "/welcome";
        });
    </script>
</body>
</html>
