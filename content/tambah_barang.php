<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <script>
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        html, body {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Tombol Toggle Theme -->
    <button onclick="toggleTheme()" class="fixed top-4 right-4 p-2 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors duration-300">
        <i id="icon-light" class="bi bi-sun-fill text-yellow-400"></i>
        <i id="icon-dark" class="bi bi-moon-fill text-gray-200 hidden"></i>
    </button>

    <div class="w-full h-full rounded-2xl p-6 flex flex-col">
        <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">Tambah Barang</h2>
        <div class="flex-grow overflow-auto max-w-full">
            <form action="../proses/proses_tambah.php" method="POST" class="w-full">
                <!-- Pilih Lab -->
                <label class="block mb-2 text-gray-900 dark:text-gray-100">Pilih Lab:</label>
                <select name="lokasi" id="lokasi" required onchange="updateForm()" class="w-full p-2 border rounded mb-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                    <option value="Lab RPL 1">Lab RPL 1</option>
                    <option value="Lab RPL 2">Lab RPL 2</option>
                    <option value="Lab MM">Lab MM</option>
                </select>

                <!-- Form Lab RPL -->
                <div id="lab_rpl_form">
                    <label class="block mb-2 text-gray-900 dark:text-gray-100">Nomor Laptop:</label>
                    <input type="number" name="nomor_laptop" class="w-full p-2 border rounded mb-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors duration-300">

                    <label class="block mb-2 text-gray-900 dark:text-gray-100">Kelengkapan:</label>
                    <div class="flex items-center gap-3 mb-3">
                        <input type="checkbox" name="mouse" value="1" class="text-blue-500"> <span class="text-gray-900 dark:text-gray-100">Mouse</span>
                        <input type="checkbox" name="charger" value="1" class="text-blue-500"> <span class="text-gray-900 dark:text-gray-100">Charger</span>
                        <input type="checkbox" name="headset" value="1" class="text-blue-500"> <span class="text-gray-900 dark:text-gray-100">Headset</span>
                    </div>
                </div>

                <!-- Form Lab MM -->
                <div id="lab_mm_form" style="display: none;">
                    <label class="block mb-2 text-gray-900 dark:text-gray-100">Nama Barang:</label>
                    <input type="text" name="nama_barang" class="w-full p-2 border rounded mb-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition-colors duration-300">Tambah Barang</button>
            </form>
        </div>
    </div>

    <!-- Script untuk Toggle Form -->
    <script>
    function updateForm() {
        let lokasi = document.getElementById("lokasi").value;
        let labRPL = document.getElementById("lab_rpl_form");
        let labMM = document.getElementById("lab_mm_form");

        if (lokasi === "Lab MM") {  
            labRPL.style.display = "none";
            labMM.style.display = "block";
        } else {
            labRPL.style.display = "block";
            labMM.style.display = "none";
        }
    }
    </script>

    <!-- Script untuk Toggle Dark Mode -->
    <script>
        // Fungsi untuk toggle tema
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                document.getElementById('icon-light').classList.add('hidden');
                document.getElementById('icon-dark').classList.remove('hidden');
            } else {
                localStorage.setItem('theme', 'light');
                document.getElementById('icon-light').classList.remove('hidden');
                document.getElementById('icon-dark').classList.add('hidden');
            }
        }

        // Set ikon tema saat halaman dimuat
        if (localStorage.getItem('theme') === 'dark') {
            document.getElementById('icon-light').classList.add('hidden');
            document.getElementById('icon-dark').classList.remove('hidden');
        } else {
            document.getElementById('icon-light').classList.remove('hidden');
            document.getElementById('icon-dark').classList.add('hidden');
        }
    </script>
</body>
</html>