<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Account Waiters</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Ensure the body and html take the full height */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Flexbox setup for the page */
        .page-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex-grow: 1;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    @include('partials-admin.navbar')

    <!-- Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">List Account Costomers</h2>

       <!-- Top Controls -->
<div class="flex flex-wrap justify-between items-center gap-4 mb-8">
    <input type="text" placeholder="Cari akun Customer" class="px-4 py-2 border rounded-md w-64 shadow-sm focus:ring focus:ring-blue-300">
    <div class="ml-auto text-gray-700">
    Total accounts: <strong class="text-green-600">{{ $totalCustomers }}</strong>
    </div>
</div>

<!-- Tombol Buat Akun -->
<div class="mb-6">
    <a href="{{ route('create-accounts.index') }}" class="inline-block bg-green-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-green-700 transition duration-200">
        + Buat Akun Pelanggan
    </a>
</div>


        <!-- Account Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="account-list">
        @foreach ($customers as $customer)
<div class="relative bg-white rounded-lg shadow-lg p-5 hover:scale-105 transition-transform account-card" data-customer-id="{{ $customer->id }}">
    <!-- Tombol Hapus -->
    <button class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-xl font-bold delete-btn">❌</button>

    <div class="flex items-center gap-4 mb-4">
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl font-bold">👤</div>
        <div>
            <p class="font-semibold text-gray-800">{{ $customer->name }}</p>
            <p class="text-sm text-gray-500">Email : {{ $customer->email }}</p>
            <p class="text-sm text-gray-500">No. HP : {{ $customer->number_phone }}</p>
        </div>
    </div>
</div>
@endforeach

        </div>
    </div>


    <!-- Modal Konfirmasi Hapus -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Penghapusan</h3>
        <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus akun ini?</p>
        <div class="mt-4 flex justify-between">
            <button id="cancel-delete" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
            <button id="confirm-delete" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
        </div>
    </div>
</div>

          <!-- Tombol Chat -->
<a href="/chat" class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-full shadow-lg border border-black">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.77 9.77 0 01-4-.857L3 20l1.543-3.86A7.96 7.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
  </svg>
</a>

    <!-- Footer -->
    @include('partials.footer')
    <!-- JavaScript -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const accountList = document.getElementById("account-list");
        const deleteModal = document.getElementById("delete-modal");
        const confirmDeleteBtn = document.getElementById("confirm-delete");
        const cancelDeleteBtn = document.getElementById("cancel-delete");
        let currentCard;
        let currentCustomerId;

        // Menampilkan modal konfirmasi ketika tombol hapus diklik
        accountList.addEventListener("click", function (e) {
            if (e.target.classList.contains("delete-btn")) {
                currentCard = e.target.closest(".account-card");
                currentCustomerId = currentCard.getAttribute("data-customer-id");
                deleteModal.classList.remove("hidden"); // Tampilkan modal konfirmasi
            }
        });

        // Tombol batal untuk menutup modal konfirmasi
        cancelDeleteBtn.addEventListener("click", function () {
            deleteModal.classList.add("hidden"); // Sembunyikan modal
        });

        // Tombol hapus untuk menghapus data
        confirmDeleteBtn.addEventListener("click", function () {
            // Menghapus data dari database
            fetch(`/delete-account/${currentCustomerId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan CSRF token ditambahkan
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentCard.remove(); // Menghapus card dari tampilan
                    deleteModal.classList.add("hidden"); // Sembunyikan modal setelah penghapusan
                } else {
                    alert("Gagal menghapus akun.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan.");
            });
        });
    });
</script>



</body>
</html>
