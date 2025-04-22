<!-- login-desktop.html -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
<body class="flex items-center justify-center min-h-screen px-10">
  <div class="w-full max-w-md bg-[#5b130a] bg-opacity-90 p-10 rounded-lg shadow-2xl text-center">
    <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="mx-auto mb-6 h-16">
    <h1 class="text-lg font-bold">RUMAH MAKAN</h1>
    <h2 class="text-3xl font-extrabold text-yellow-400 mb-6">Kampoeng Sawah</h2>

    <form action="{{ route('loginAccount') }}" method="POST" class="space-y-5">
      @csrf
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">👤</span>
        <input type="text" name="username" placeholder="Username" class="w-full pl-10 p-3 rounded-md border border-gray-300 text-black" required>
      </div>
      <div class="relative">
        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">#</span>
        <input type="password" name="password" placeholder="Kode Akses" class="w-full pl-10 p-3 rounded-md border border-gray-300 text-black" required>
      </div>
      <button type="submit" class="w-full bg-yellow-400 text-[#731b0c] font-bold py-3 rounded-md hover:bg-yellow-300">Login</button>
    </form>
  </div>
</body>
</html>
