<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Voucher</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Voucher</h1>

    <a href="/vouchers/create"
       class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg mb-4 hover:bg-indigo-700">
      + Tambah Voucher
    </a>

    <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2 border">Kode</th>
          <th class="px-4 py-2 border">Diskon</th>
          <th class="px-4 py-2 border">Expired</th>
          <th class="px-4 py-2 border">Deskripsi</th>
          <th class="px-4 py-2 border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="px-4 py-2 border text-center">DISKON10</td>
          <td class="px-4 py-2 border text-center">10%</td>
          <td class="px-4 py-2 border text-center">2025-12-31</td>
          <td class="px-4 py-2 border">Diskon akhir tahun</td>
          <td class="px-4 py-2 border text-center space-x-2">
            <a href="/vouchers/1/edit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
            <form action="/vouchers/1" method="POST" class="inline">
              <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
