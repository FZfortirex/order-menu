<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Voucher</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Voucher</h1>

    <form action="/vouchers" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-700">Kode Voucher</label>
        <input type="text" name="code" class="w-full border p-2 rounded" placeholder="Masukkan kode">
      </div>

      <div>
        <label class="block text-gray-700">Diskon (%)</label>
        <input type="number" name="discount" class="w-full border p-2 rounded" placeholder="Contoh: 20">
      </div>

      <div>
        <label class="block text-gray-700">Tanggal Expired</label>
        <input type="date" name="expired_at" class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block text-gray-700">Deskripsi</label>
        <textarea name="description" class="w-full border p-2 rounded" placeholder="Keterangan voucher"></textarea>
      </div>

      <div class="flex justify-between">
        <a href="/vouchers" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
      </div>
    </form>
  </div>
</body>
</html>
