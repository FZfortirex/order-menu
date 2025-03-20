<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-red-900 text-white">
     <!-- Navbar -->
     @include('partials.navbar')
    <div class="max-w-4xl mx-auto p-8">



        <h1 class="text-3xl font-bold mb-6">KONTAK</h1>

        <div class="grid grid-cols-2 gap-8">
            <form class="space-y-4">
                <input type="text" placeholder="Nama Anda" class="w-full p-3 rounded-md bg-red-700 text-white">
                <input type="text" placeholder="No. Telp" class="w-full p-3 rounded-md bg-red-700 text-white">
                <input type="email" placeholder="Email" class="w-full p-3 rounded-md bg-red-700 text-white">
                <input type="text" placeholder="Subjek" class="w-full p-3 rounded-md bg-red-700 text-white">
                <textarea placeholder="Pesan Anda" class="w-full p-3 rounded-md bg-red-700 text-white h-32"></textarea>
                <button class="bg-yellow-500 text-black p-3 rounded-md font-bold">Submit</button>
            </form>

        <div>
    <h2 class="text-lg font-bold mb-2">Lokasi Kampoeng Sawah</h2>
    <a href="https://maps.app.goo.gl/1RF3GNKJdJiTqD9XA" target="_blank">
        <img src="{{ asset('images/lokasi.png') }}" alt="Lokasi Maps" class="w-full rounded-md shadow-lg">
    </a>
    <p class="mt-4">Jam Operasional:</p>
    <p>Senin-Minggu: <span class="text-red-400">09:00-19:00</span></p>
        </div>


        </div>


    </div>
     <!-- Footer -->
     @include('partials.footer')

</body>
</html>