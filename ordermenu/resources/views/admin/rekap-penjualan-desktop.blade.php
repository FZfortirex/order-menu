<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penjualan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Kontainer Grafik -->
    <div class="max-w-4xl mx-auto mt-10 px-6">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h2 class="text-2xl font-bold">Grafik Penjualan</h2>
                <form method="GET" action="/rekap-penjualan">
                    <select name="tipe" onchange="this.form.submit()"
                            class="border border-gray-300 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-400 rounded-lg px-4 py-2 text-sm shadow-sm">
                        <option value="harian" {{ $tipe === 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="bulanan" {{ $tipe === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </form>
            </div>

            <div class="relative">
                <canvas id="chartPenjualan" class="w-full h-80"></canvas>
            </div>
        </div>
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
                    backgroundColor: 'rgba(251, 191, 36, 0.8)', // yellow-400
                    borderColor: 'rgba(202, 138, 4, 1)', // yellow-700
                    borderWidth: 1,
                    borderRadius: 10,
                    barThickness: 40,
                    maxBarThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
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
                            size: 18,
                            weight: 'bold'
                        },
                        padding: {
                            top: 10,
                            bottom: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            stepSize: 10000
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Penjualan (Rp)',
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: '{{ ucfirst($tipe) }}',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
