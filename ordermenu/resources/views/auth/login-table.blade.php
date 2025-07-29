<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Kampoeng Sawah</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #731b0c;
      color: white;
      background-image: url('/background.png');
      background-size: cover;
      background-position: center;
    }

    .select-wrapper::after {
      content: "▼";
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #555;
      pointer-events: none;
    }

    select:invalid {
      color: #9ca3af; /* Tailwind's gray-400 */
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen px-4">
  <div class="w-full max-w-md bg-[#5b130a] bg-opacity-90 p-8 rounded-2xl shadow-2xl text-center backdrop-blur-sm">
    <img src="{{ asset('images/logo_waroeng_sawah.png') }}" alt="Logo" class="mx-auto mb-4 h-16 drop-shadow-md">
    <h1 class="text-lg font-semibold tracking-wider">RUMAH MAKAN</h1>
    <h2 class="text-3xl font-extrabold text-yellow-400 mb-8 drop-shadow">Kampoeng Sawah</h2>

    <form action="{{ route('loginTable') }}" method="POST" class="space-y-5 text-left">
      @csrf
      <div class="relative select-wrapper">
        <select name="username" required class="w-full p-3 pr-10 rounded-md border border-gray-300 text-black bg-white appearance-none">
          <option value="" disabled selected hidden>Pilih Nomor Meja</option>
          @for ($i = 1; $i <= 10; $i++)
              <option value="{{ $i }}">Meja {{ $i }}</option>
          @endfor
        </select>
      </div>

      <button type="submit" class="w-full bg-yellow-400 text-[#5b130a] font-bold py-3 rounded-md hover:bg-yellow-300 shadow-md transition-all duration-200">
        Masuk
      </button>
    </form>

    <p class="mt-6 text-sm text-gray-200">
      Sudah punya akun?
      <a href="{{ route('loginAccount') }}" class="text-yellow-400 hover:underline font-medium">Login di sini</a>
    </p>
  </div>
</body>
</html>
