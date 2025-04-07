<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Aplikasi Peminjaman</title>
    <style>
        body {
            position: relative;
            overflow: hidden;
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
    </style>
</head>

<body class="h-screen flex items-center justify-center bg-gray-900">
    <video autoplay loop muted playsinline class="absolute w-full h-full object-cover">
        <!-- <source src="assets/bg.mp4" type="video/mp4"> -->
    </video>

    <div class="bg-gray-800 opacity-90 shadow-lg rounded-xl p-6 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-white mb-4">Login</h2>

        <form method="POST" action="proses/login_proses.php" autocomplete="off" class="space-y-4">
            <div id="username-field">
                <label for="username" class="block font-medium text-gray-300">Nama</label>
                <input type="text" name="username" id="username" placeholder="Masukkan nama" required
                    class="w-full px-4 py-2 mt-1 border border-gray-600 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div id="credential-field">
                <label for="credential" class="block font-medium text-gray-300">
                    Password (NIS)
                </label>
                <input type="password" name="credential" id="credential" placeholder="Masukkan password atau NIS" required
                    class="w-full px-4 py-2 mt-1 border border-gray-600 bg-gray-700 text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <button type="submit"
                class="w-full h-14 bg-gradient-to-r from-cyan-500 to-blue-500 text-white py-2 rounded-lg mt-2 hover:bg-blue-700 transition duration-200">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>