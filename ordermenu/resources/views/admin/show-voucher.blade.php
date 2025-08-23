<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Voucher</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Voucher</h1>

    <div class="space-y-3">
      <div>
        <span class="font-semibold">Kode Voucher:</span>
        <p class="text-gray-700">DISKON10</p>
      </div>

      <div>
        <span class="font-semibold">Diskon:</span>
        <p class="text-gray-700">10%</p>
      </div>

      <div>
        <span class="font-semibold">Expired:</span>
        <p class="text-gray-700">2025-12-31</p>
      </div>

      <div>
        <span class="font-semibold">Deskripsi:</span>
        <p class="text-gray-700">Diskon akhir tahun</p>
      </div>
    </div>

    <div class="flex justify-between mt-6">
      <a href="/vouchers" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
      <a href="/vouchers/1/edit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
    </div>
  </div>
</body>
</html>
