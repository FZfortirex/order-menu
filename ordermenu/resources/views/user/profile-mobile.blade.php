<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Mobile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans">
  <!-- Navbar -->
@include('partials.navbar')

  <!-- Back & Profile Nav -->
  <div class="flex justify-between items-center px-4 py-2 border-b">
    <a href="{{ url('/menu') }}" class="text-base font-medium">&#x2190; BACK</a>
    <span class="text-sm font-medium">Profile</span>
    <div></div>
  </div>

  <!-- Profile Section -->
  <div class="p-4">
    <div class="flex items-center space-x-4">
      <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-3xl font-bold text-white">
        {{ strtoupper(substr($user->name, 0, 1)) }} 
      </div>
      <div>
        <div class="text-base font-semibold">{{ $user->name }}</div>
        <div class="text-xs text-gray-500">Hastag</div>
      </div>
      <div class="ml-auto text-xl">💬</div>
    </div>

    <!-- Poin Card -->
    <div class="border mt-6 p-4 rounded-md">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="text-lg">💲</div>
          <div class="text-base font-semibold">{{ $user->my_points }} poin</div>
        </div>
        <button class="text-sm text-white bg-maroon-800 px-3 py-1 rounded flex items-center">
          Tukar Poin
          <span class="ml-1">➡️</span>
        </button>
      </div>
    </div>
  </div>
</body>
</html>
