<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Orders - Mobile</title>
</head>
<body>
    <h2>List Menu Orders (Mobile View)</h2>
    <div>
        @foreach ($orders as $order)
            <div>
                <p>Nama: {{ $order['name'] }}</p>
                <p>Meja: {{ $order['table'] }}</p>
                <p>Total Harga: {{ $order['total_price'] }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>
