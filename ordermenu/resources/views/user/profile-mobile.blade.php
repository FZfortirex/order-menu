<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Profile Card -->
    <div class="flex-grow px-4 py-6">
        <div class="max-w-md mx-auto bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name) }}&background=random" alt="Foto Profil" class="w-24 h-24 rounded-full mb-4 shadow-md">
                <h2 class="text-xl font-semibold text-gray-800">{{ $user->full_name }}</h2>
                <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>

                <div class="w-full mt-4 space-y-3">
                    <div class="bg-gray-100 px-4 py-2 rounded-lg text-sm">
                        <span class="font-medium text-gray-600">Username: </span>{{ $user->username }}
                    </div>
                    <div class="bg-gray-100 px-4 py-2 rounded-lg text-sm">
                        <span class="font-medium text-gray-600">Grade: </span>{{ $user->grade->grade ?? '-' }}
                    </div>
                    <div class="bg-gray-100 px-4 py-2 rounded-lg text-sm">
                        <span class="font-medium text-gray-600">Department: </span>{{ $user->department->name ?? '-' }}
                    </div>
                </div>

                <a href="{{ route('logout') }}" class="mt-6 inline-block bg-red-500 text-white font-semibold px-6 py-2 rounded-full shadow hover:bg-red-600 transition">
                    Keluar
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
