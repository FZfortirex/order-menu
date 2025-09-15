<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Meja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Status Meja</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($tableData as $data)
            <div class="bg-white p-4 shadow rounded text-center">
                <h2 class="text-lg font-semibold mb-2">Meja {{ $data['meja'] }}</h2>

                @if ($data['status'] === 'Terisi')
                    <p class="text-green-600 font-bold">Terisi</p>
                    <form action="{{ route('meja.kosongkan', $data['meja']) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <button 
                            type="submit" 
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Kosongkan Meja
                        </button>
                    </form>
                @else
                    <p class="text-red-600 font-bold">Kosong</p>
                @endif

                @if ($data['user'])
                    <p class="text-sm mt-2 text-gray-700">User: {{ $data['user']->name }}</p>
                    <p class="text-sm text-gray-500">{{ $data['user']->email }}</p>
                @else
                    <p class="text-sm mt-2 text-gray-500">Belum ada customer</p>
                @endif
            </div>
        @endforeach
    </div>
</body>
</html>
