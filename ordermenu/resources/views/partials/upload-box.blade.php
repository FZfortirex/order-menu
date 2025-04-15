<!-- Kotak Upload -->
<div class="mb-6">
    <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf
        <input type="file" name="foto" id="fotoInput" class="hidden" onchange="document.getElementById('uploadForm').submit()" required>

        <button type="button" onclick="document.getElementById('fotoInput').click()"
            class="w-40 h-40 bg-white border-2 border-dashed border-gray-300 flex flex-col items-center justify-center rounded-lg hover:bg-gray-100 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0L8 8m4-4l4 4" />
            </svg>
            <span class="text-sm text-gray-600 font-semibold">Upload Sekarang</span>
        </button>
    </form>
</div>
