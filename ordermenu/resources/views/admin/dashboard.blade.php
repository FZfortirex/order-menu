<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Menu Orders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .navbar {
            background-color: #7d1212;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
        }
        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        .nav-links li {
            display: inline;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            text-align: center;
        }
        .top-controls {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .search-bar {
            padding: 8px;
            width: 200px;
        }
        .orders-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .order-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .order-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avatar {
            width: 50px;
            height: 50px;
            background: #ccc;
            border-radius: 50%;
        }
        .order-actions {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .cancel {
            background: white;
            border: 2px solid red;
            color: red;
        }
        .process {
            background: blue;
            color: white;
        }
        .complete {
            background: green;
            color: white;
        }
        .done {
            background: yellow;
            color: black;
        }
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
            }
            .nav-links {
                flex-direction: column;
                padding: 0;
            }
            .top-controls {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            .orders-container {
                flex-direction: column;
                align-items: center;
            }
            .order-card {
                width: 90%;
            }
            .order-actions {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                gap: 5px;
            }
            .btn {
                flex: 1;
                text-align: center;
            }
            .top-controls input,
            .top-controls button {
                width: 90%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">Kampoeng Sawah</div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">Galeri</a></li>
            <li><a href="#">Kontak</a></li>
            <li><a href="#">Opsi &#9662;</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>List Menu Orders</h2>
        <div class="top-controls">
            <input type="text" placeholder="Type here" class="search-bar">
            <button class="btn">Search Account</button>
            <p class="table-info">Available tables: <strong>33/36</strong></p>
            <button class="btn">Create Account</button>
        </div>

        <div class="orders-container">
            <div class="order-card">
                <div class="order-header">
                    <div class="avatar"></div>
                    <div>
                        <p class="name">Nama</p>
                        <p class="table">meja</p>
                        <p class="price">Total Harga: 40rb</p>
                    </div>
                </div>
                <div class="order-actions">
                    <button class="btn cancel">Cancel</button>
                    <button class="btn process">Process</button>
                    <button class="btn complete">Complete</button>
                    <button class="btn done">Done</button>
                </div>
            </div>
            <div class="order-card">
                <div class="order-header">
                    <div class="avatar"></div>
                    <div>
                        <p class="name">Nama</p>
                        <p class="table">meja</p>
                        <p class="price">Total Harga: 40rb</p>
                    </div>
                </div>
                <div class="order-actions">
                    <button class="btn cancel">Cancel</button>
                    <button class="btn process">Process</button>
                    <button class="btn complete">Complete</button>
                    <button class="btn done">Done</button>
                </div>
            </div>
            <div class="order-card">
                <div class="order-header">
                    <div class="avatar"></div>
                    <div>
                        <p class="name">Nama</p>
                        <p class="table">meja</p>
                        <p class="price">Total Harga: 40rb</p>
                    </div>
                </div>
                <div class="order-actions">
                    <button class="btn cancel">Cancel</button>
                    <button class="btn process">Process</button>
                    <button class="btn complete">Complete</button>
                    <button class="btn done">Done</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Tombol Profile -->
  <a href="/profile" class="fixed bottom-4 right-4 bg-yellow-400 hover:bg-yellow-300 text-black p-4 rounded-full shadow-lg border border-black">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.004 9.004 0 0112 15c2.072 0 3.98.707 5.465 1.898M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
  </a>

    <script src="script.js"></script>
</body>
</html>