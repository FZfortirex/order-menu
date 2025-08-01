<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>QR Login</title>
</head>
<body>
  <h2>Scan QR untuk Login Meja {{ $meja }}</h2>

  {!! QrCode::size(250)->generate(url('/login-table?meja=' . $meja)) !!}

</body>
</html>
