<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">QR Code untuk Menu Meja</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($qrData as $data)
            <div class="bg-white p-4 shadow rounded text-center">
                <h2 class="text-lg font-semibold mb-2">Meja {{ $data['meja'] }}</h2>
                <div class="flex justify-center">
                    {!! $data['qr'] !!}
                </div>
                <p class="text-sm mt-2 break-all text-blue-600">{{ $data['url'] }}</p>
            </div>
        @endforeach
    </div>
</body>
</html>