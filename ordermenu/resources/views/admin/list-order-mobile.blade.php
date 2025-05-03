<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Orders - Mobile</title>
</head>
<body>
    <h2>List Menu Orders (Mobile View)</h2>
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <input type="text" placeholder="Cari pesanan..." class="px-4 py-2 border rounded-md w-64 shadow-sm focus:ring focus:ring-red-300">
        <div class="ml-auto text-gray-700">
            Available tables: <strong class="text-green-600">{{ $availableTables }}/{{ $totalTables }}</strong>
        </div>
    </div>
    <div>
        @foreach ($orders as $order)
            <div>
                <p>Antrian: {{ $order->id }}</p>
                <p>Meja: {{ $order->table ?? '-' }}</p>
                <p>Total Harga: {{ number_format($order->total_price, 0, ',', '.') }} Rp</p>
                <p>Catatan : {{ $order->additional_note }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>
