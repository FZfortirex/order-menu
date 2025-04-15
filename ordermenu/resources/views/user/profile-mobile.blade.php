<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Mobile</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans">
  <!-- Navbar -->
@include('partials.navbar')

  <!-- Back & Profile Nav -->
  <div class="flex justify-between items-center px-4 py-2 border-b">
    <button class="text-sm font-medium">&#x2190; BACK</button>
    <span class="text-sm font-medium">Profile</span>
    <div></div>
  </div>

  <!-- Profile Section -->
  <div class="p-4">
    <div class="flex items-center space-x-4">
      <div class="w-16 h-16 rounded-full bg-gray-300"></div>
      <div>
        <div class="text-sm font-semibold">Username</div>
        <div class="text-xs text-gray-500">Hastag</div>
      </div>
      <div class="ml-auto text-xl">💬</div>
    </div>

    <!-- Poin Card -->
    <div class="border mt-6 p-4 rounded-md">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="text-lg">💲</div>
          <div class="text-sm font-semibold">0 poin</div>
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
