<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-red-900 text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('partials.navbar')

    <main class="max-w-md mx-auto p-6 flex-grow">
        <h1 class="text-center text-2xl font-bold mb-6">Kontak</h1>

        <form method="POST" action="{{ route('kontak.store') }}" id="contact-form" class="space-y-4">
            @csrf
            <input
                type="text"
                name="name"
                placeholder="Nama Anda"
                required
                class="w-full p-3 rounded-md bg-red-700 text-white placeholder-red-300 focus:outline-yellow-400"
            />

            <input
                type="tel"
                name="number_phone"
                placeholder="No. Telp"
                required
                class="w-full p-3 rounded-md bg-red-700 text-white placeholder-red-300 focus:outline-yellow-400"
            />

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
                class="w-full p-3 rounded-md bg-red-700 text-white placeholder-red-300 focus:outline-yellow-400"
            />

            <textarea
                name="message"
                placeholder="Pesan Anda"
                rows="5"
                required
                class="w-full p-3 rounded-md bg-red-700 text-white placeholder-red-300 focus:outline-yellow-400 resize-none"
            ></textarea>

            <button
                type="submit"
                class="bg-yellow-500 text-black p-3 rounded-md font-bold w-full hover:bg-yellow-400 transition"
            >
                Submit
            </button>
        </form>
    </main>

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
