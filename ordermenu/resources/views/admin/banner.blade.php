<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Banner</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="from-red-900 to-indigo-200 min-h-screen flex items-center justify-center px-4 py-8 font-sans relative">

  <!-- Tombol Back -->
  <a href="javascript:history.back()"
     class="absolute top-4 left-4 flex items-center space-x-2 text-gray-700 hover:text-gray-900 font-medium text-lg px-3 py-2 rounded-lg hover:bg-gray-100 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M12.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L8.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
    </svg>
    <span>Back</span>
  </a>

  <!-- Card -->
  <div class="w-full max-w-6xl bg-white rounded-2xl shadow-xl p-8 transition-all duration-300">
    <h1 class="text-3xl font-extrabold text-yellow-600 mb-8 text-center">Tambah Banner</h1>

    <form method="POST" action="{{ route('admin.banner.save') }}" enctype="multipart/form-data">
      @csrf

      <!-- Grid Responsive -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([1, 2, 3, 4] as $i)
          @php $banner = $banners->firstWhere('id', $i); @endphp

          <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-white">
            <h2 class="text-lg font-semibold text-yellow-600 mb-4 text-center">Banner {{ $i }}</h2>

            <!-- Preview Gambar -->
            <div class="relative w-full aspect-[4/3] bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
              @if($banner && $banner->image)
                <img id="previewImage_{{ $i }}" src="{{ asset($banner->image) }}" class="object-cover w-full h-full">
              @else
                <img id="previewImage_{{ $i }}" src="" class="object-cover w-full h-full hidden">
                <span id="noImageText_{{ $i }}" class="text-gray-400 text-xs text-center">Belum ada banner</span>
              @endif
            </div>

            <!-- Upload Gambar -->
            <div class="mt-3">
              <input type="file" name="image_{{ $i }}" id="image_{{ $i }}" class="hidden" onchange="previewImage(event, {{ $i }})">
              <label for="image_{{ $i }}" 
                    class="block w-full text-center cursor-pointer bg-yellow-50 text-yellow-700 hover:bg-yellow-100 
                            py-2 px-4 rounded-md text-sm font-semibold border border-yellow-300 transition">
                Tambah Gambar
              </label>
            </div>

            <!-- Tombol Hapus Gambar -->
            <div class="mt-2">
              <input type="checkbox" name="clear_banner[]" value="{{ $i }}" id="clearCheckbox_{{ $i }}" class="hidden">
              <button type="button"
                      id="deleteButton_{{ $i }}"
                      onclick="markBannerForClear({{ $i }})"
                      class="w-full px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-700 transition {{ $banner && $banner->has_image ? '' : 'hidden' }}">
                Hapus Banner
              </button>
            </div>

            <!-- Input Nama Menu -->
            <div class="relative mt-4 {{ $banner && $banner->has_image ? '' : 'hidden' }}" id="menuSection_{{ $i }}">
              <input type="text" name="menu_name_{{ $i }}" id="menuInput_{{ $i }}" autocomplete="off"
                    value="{{ $banner->menu->name ?? '' }}"
                    placeholder="Nama Menu (Opsional)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 transition">
              <input type="hidden" name="menu_id_{{ $i }}" id="menuId_{{ $i }}" value="{{ $banner->menu_id ?? '' }}">

              <ul id="suggestionBox_{{ $i }}"
                  class="absolute z-10 bg-white w-full border border-gray-200 rounded-lg mt-1 hidden max-h-40 overflow-y-auto shadow">
              </ul>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Tombol Simpan -->
      <div class="flex justify-center mt-8">
        <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:shadow-lg transition-all duration-300">
          Simpan Semua
        </button>
      </div>
    </form>
  </div>

  <script>
    const menus = @json($menus);

    function markBannerForClear(index) {
      const checkbox = document.getElementById(`clearCheckbox_${index}`);
      const preview = document.getElementById(`previewImage_${index}`);
      const noImageText = document.getElementById(`noImageText_${index}`);
      const menuSection = document.getElementById(`menuSection_${index}`);
      const menuInput = document.getElementById(`menuInput_${index}`);
      const menuId = document.getElementById(`menuId_${index}`);
      const fileInput = document.getElementById(`image_${index}`);
      const deleteButton = document.getElementById(`deleteButton_${index}`);

      if (checkbox) checkbox.checked = true;
      if (preview) { preview.src = ''; preview.classList.add('hidden'); }
      if (noImageText) noImageText.classList.remove('hidden');
      if (menuSection) menuSection.classList.add('hidden');
      if (menuInput) menuInput.value = '';
      if (menuId) menuId.value = '';
      if (fileInput) fileInput.value = '';
      if (deleteButton) deleteButton.classList.add('hidden');
    }

    function previewImage(event, index) {
      const input = event.target;
      const reader = new FileReader();
      reader.onload = function () {
        const preview = document.getElementById(`previewImage_${index}`);
        const noImageText = document.getElementById(`noImageText_${index}`);
        const menuSection = document.getElementById(`menuSection_${index}`);
        const deleteButton = document.getElementById(`deleteButton_${index}`);
        
        preview.src = reader.result;
        preview.classList.remove('hidden');
        if (noImageText) noImageText.classList.add('hidden');
        if (menuSection) menuSection.classList.remove('hidden');
        if (deleteButton) deleteButton.classList.remove('hidden'); // <-- tampilkan tombol hapus
      };
      if (input.files[0]) reader.readAsDataURL(input.files[0]);
    }

    [1, 2, 3, 4].forEach(i => {
      const input = document.getElementById(`menuInput_${i}`);
      const hidden = document.getElementById(`menuId_${i}`);
      const box = document.getElementById(`suggestionBox_${i}`);

      input.addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        box.innerHTML = '';
        hidden.value = '';
        if (keyword.trim() === '') { box.classList.add('hidden'); return; }
        const filtered = menus.filter(menu => menu.name.toLowerCase().includes(keyword));
        if (filtered.length === 0) { box.classList.add('hidden'); return; }
        filtered.forEach(menu => {
          const li = document.createElement('li');
          li.textContent = menu.name;
          li.className = 'px-4 py-2 hover:bg-yellow-100 cursor-pointer';
          li.addEventListener('click', () => {
            input.value = menu.name;
            hidden.value = menu.id;
            box.classList.add('hidden');
          });
          box.appendChild(li);
        });
        box.classList.remove('hidden');
      });

      document.addEventListener('click', function (e) {
        if (!box.contains(e.target) && e.target !== input) {
          box.classList.add('hidden');
        }
      });
    });

    window.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('input[type="file"]').forEach(fileInput => fileInput.value = '');
    });
  </script>

</body>
</html>
