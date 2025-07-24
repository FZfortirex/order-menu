<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Kontainer Grafik -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Grafik Penjualan</h2>

            <form method="GET" action="/rekap-penjualan">
                <select name="tipe" onchange="this.form.submit()" class="border border-gray-300 rounded px-3 py-1 text-sm">
                    <option value="harian" {{ $tipe === 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="bulanan" {{ $tipe === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </form>
        </div>

        <canvas id="chartPenjualan" class="w-full h-80"></canvas>
    </div>

    <!-- Footer -->
    @include('partials-admin.footer')

    <!-- Script Chart -->
    <script>
        const ctx = document.getElementById('chartPenjualan').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($totals) !!},
                    backgroundColor: 'rgba(251, 191, 36, 0.7)',
                    borderColor: 'rgba(202, 138, 4, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total Penjualan per {{ ucfirst($tipe) }}',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
