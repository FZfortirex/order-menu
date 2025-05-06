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
    <div class="max-w-md mx-auto p-4">
        <h1 class="text-center text-2xl font-bold">Kontak</h1>

        <form method="POST" action="{{ route('kontak.store') }}" class="mt-4" id="contact-form">
                @csrf
                <input type="text" name="name" placeholder="Nama Anda" class="w-full p-3 rounded-md bg-red-700 text-white">
                <input type="text" name="number_phone" placeholder="No. Telp" class="w-full p-3 rounded-md bg-red-700 text-white">
                <input type="email" name="email" placeholder="Email" class="w-full p-3 rounded-md bg-red-700 text-white">
                <textarea name="message" placeholder="Pesan Anda" class="w-full p-3 rounded-md bg-red-700 text-white h-32"></textarea>
                <button class="bg-yellow-500 text-black p-3 rounded-md font-bold">Submit</button>
            </form>
    </div>
    <!-- Footer -->
    @include('partials.footer')
</body>
<script>
    document.getElementById('send-wa').addEventListener('click', function() {
        let name = document.getElementById('name').value;
        let phone = document.getElementById('phone').value;
        let email = document.getElementById('email').value;
        let subject = document.getElementById('subject').value;
        let message = document.getElementById('message').value;

        // Nomor WhatsApp tujuan (ganti dengan nomor asli, tanpa "+" dan dengan kode negara)
        let phoneNumber = "628123456789"; // Contoh: 628123456789 (untuk +62)

        // Format pesan
        let whatsappMessage = `Halo, saya ${name}.%0A%0ANo. Telp: ${phone}%0AEmail: ${email}%0A%0A*Subjek:* ${subject}%0A%0A*Pesan:*%0A${message}`;

        // Buka WhatsApp dengan pesan
        let whatsappURL = `https://wa.me/${phoneNumber}?text=${whatsappMessage}`;
        window.open(whatsappURL, "_blank");
    });
</script>
</html>