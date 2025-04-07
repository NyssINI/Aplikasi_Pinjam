<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== "Siswa") {
    echo "<script>
            alert('Akses ditolak! Silakan login terlebih dahulu.');
            window.location = '../index.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Siswa</title>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <style>
        html,
        body {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 h-screen overflow-auto transition-colors duration-300 font-serif">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 shadow-md fixed w-full z-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <span class="text-xl font-bold text-gray-900 dark:text-gray-100">Dashboard Siswa</span>
                <div id="theme-toggle" class="relative w-16 h-8 bg-gray-300 dark:bg-gray-700 rounded-full cursor-pointer transition-colors duration-300" onclick="toggleTheme()">
                    <i id="icon-light" class="absolute left-2 top-1/2 transform -translate-y-1/2 text-yellow-400 text-lg"></i>
                    <i id="icon-dark" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-200 text-lg hidden"></i>
                    <span id="toggle-ball" class="absolute left-1 top-1 w-6 h-6 bg-white dark:bg-gray-200 rounded-full transition-transform duration-300"></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar fixed top-16 bottom-0 left-0 lg:left-0 -left-72 p-2 w-[300px] overflow-y-auto text-center bg-white dark:bg-gray-800 shadow-md transition-all duration-300">
        <div class="text-gray-900 dark:text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center">
                <i class="bi bi-person-circle px-2 py-1 bg-gray-300 dark:bg-gray-700 rounded-md"></i>
                <h1 class="font-bold text-[25px] ml-3">Siswa</h1>
                <i class="bi bi-x-lg ml-auto cursor-pointer lg:hidden" onclick="Close()"></i>
            </div>
            <hr class="border-gray-300 dark:border-gray-600 my-2">
            <a href="dashboard_siswa.php" class="block">
                <div class="py-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-speedometer2 text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Dashboard</span>
                </div>
            </a>
            <a href="?page=histori_peminjaman" class="block">
                <div class="py-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-clock-history text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Histori Peminjaman</span>
                </div>
            </a>
            <hr class="border-gray-300 dark:border-gray-600 my-2">
            <a href="../logout.php" class="block">
                <div class="py-2.5 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-box-arrow-right text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Logout</span>
                </div>
            </a>
        </div>
    </div>

    <div class="pt-16 lg:ml-[320px] h-screen">
        <div class="container mx-auto px-4 h-full">
            <div class="grid gap-6 p-6 w-full h-full">
                <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 h-full flex flex-col justify-center items-center">
                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        switch ($page) {
                            case 'histori_peminjaman':
                                include "../siswa/histori_peminjaman.php";
                                break;
                            default:
                                echo "<div class='text-center'>";
                                echo "<h2 class='text-xl font-bold'>Selamat Datang di Dashboard</h2>";
                                echo "<p class='text-gray-600 dark:text-gray-300'>Pilih menu di sidebar untuk melihat data.</p>";
                                echo "</div>";
                                break;
                        }
                    } else {
                        echo "<div class='text-center'>";
                        echo "<h2 class='text-xl font-bold'>Selamat Datang di Dashboard</h2>";
                        echo "<p class='text-gray-600 dark:text-gray-300'>Pilih menu di sidebar untuk melihat data.</p>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setLightTheme() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
                document.getElementById('toggle-ball').classList.add('translate-x-8');
                document.getElementById('icon-light').classList.add('hidden');
                document.getElementById('icon-dark').classList.remove('hidden');
                document.getElementById('icon-dark').innerHTML = '<i class="bi bi-moon-fill"></i>';
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('toggle-ball').classList.remove('translate-x-8');
                document.getElementById('icon-light').classList.remove('hidden');
                document.getElementById('icon-dark').classList.add('hidden');
                document.getElementById('icon-light').innerHTML = '<i class="bi bi-sun-fill"></i>';
            }
        }

        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                document.getElementById('toggle-ball').classList.add('translate-x-8');
                document.getElementById('icon-light').classList.add('hidden');
                document.getElementById('icon-dark').classList.remove('hidden');
                document.getElementById('icon-dark').innerHTML = '<i class="bi bi-moon-fill"></i>';
            } else {
                localStorage.setItem('theme', 'light');
                document.getElementById('toggle-ball').classList.remove('translate-x-8');
                document.getElementById('icon-light').classList.remove('hidden');
                document.getElementById('icon-dark').classList.add('hidden');
                document.getElementById('icon-light').innerHTML = '<i class="bi bi-sun-fill"></i>';
            }
        }
        setLightTheme();

        function Open() {
            let sidebar = document.querySelector('.sidebar');
            sidebar.classList.remove('-left-72');
            sidebar.classList.add('left-0');
        }

        function Close() {
            let sidebar = document.querySelector('.sidebar');
            sidebar.classList.remove('left-0');
            sidebar.classList.add('-left-72');
        }
    </script>
</body>

</html>