<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Desktop</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    @media (max-width: 1024px) {
      body {
        display: none;
      }
    }
  </style>
</head>
<body class="bg-white font-sans">
  <!-- Navbar -->
@include('partials.navbar')

  <!-- Back & Profile Nav -->
  <div class="flex justify-between items-center px-10 py-4 border-b">
    <button class="text-base font-medium">&#x2190; BACK</button>
    <span class="text-base font-medium">Profile</span>
    <div></div>
  </div>

  <!-- Profile Section -->
  <div class="px-10 py-6">
    <div class="flex items-center space-x-6">
      <div class="w-24 h-24 rounded-full bg-gray-300"></div>
      <div>
        <div class="text-base font-semibold">Username</div>
        <div class="text-sm text-gray-500">Hastag</div>
      </div>
      <div class="ml-auto text-2xl">💬</div>
    </div>

    <!-- Poin Card -->
    <div class="border mt-8 p-6 rounded-md w-1/2">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <div class="text-xl">💲</div>
          <div class="text-base font-semibold">0 poin</div>
        </div>
        <button class="text-sm text-white bg-maroon-800 px-4 py-2 rounded flex items-center">
          Tukar Poin
          <span class="ml-1">➡️</span>
        </button>
      </div>
    </div>
  </div>
</body>
</html>
