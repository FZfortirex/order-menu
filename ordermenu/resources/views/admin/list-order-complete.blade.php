@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Pesanan Selesai</h2>

    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
        <input type="text" id="search" placeholder="Cari pesanan..." class="w-1/3 p-2 border rounded">
        <div class="ml-auto text-gray-700">
            Available tables: <strong class="text-green-600">{{ $availableTables }}/{{ $totalTables }}</strong>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($listOrder as $order)
            <div class="relative bg-white rounded-lg shadow-lg p-5 hover:scale-105 transition-transform">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-20 aspect-square rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-xl font-bold">
                        👤
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Nama: {{ $order->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-500">Meja: {{ $order->table ?? '-' }}</p>
                        <p class="text-sm text-gray-500">Status: <strong class="text-green-600">{{ ucfirst($order->status) }}</strong></p>
                        @if (isset($order->total_price))
                            <p class="text-sm text-gray-500">Harga: <strong class="text-red-600">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Tidak ada pesanan selesai.</p>
        @endforelse
    </div>
</div>
@endsection
