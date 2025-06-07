<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== "Petugas") {
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
    <title>Dashboard Petugas</title>
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
</head>
<!-- Nav -->

<body class="bg-gray-100 dark:bg-gray-900 h-screen overflow-auto transition-colors duration-300 font-serif: var(--Georgia)">
    <nav class="bg-white dark:bg-gray-800 shadow-md fixed w-full z-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <span class="text-xl font-bold text-gray-900 dark:text-gray-100">Dashboard Petugas</span>
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
                <i class="bi bi-box-fill px-2 py-1 bg-gray-300 dark:bg-gray-700 rounded-md"></i>
                <h1 class="font-bold text-[25px] ml-3">BoreWira</h1>
                <i class="bi bi-x-lg ml-auto cursor-pointer lg:hidden" onclick="Close()"></i>
            </div>
            <hr class="border-gray-300 dark:border-gray-600 my-2">
            <a href="dashboard_petugas.php" class="block">
                <div class="py-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-backpack4 text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Dashboard</span>
                </div>
            </a>
            <a href="?page=histori_peminjaman" class="block">
                <div class="py-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-archive text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Barang Dipinjam</span>
                </div>
            </a>
            <a href="?page=kelola_users" class="block">
                <div class="py-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-person-plus text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Kelola Users</span>
                </div>
            </a>
            <hr class="border-gray-300 dark:border-gray-600 my-2">
            <div class="py-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700" onclick="dropdown()">
                <i class="bi bi-database-check text-gray-700 dark:text-gray-300"></i>
                <div class="flex justify-between w-full items-center">
                    <span class="text-[18px] ml-4">Data Peminjaman</span>
                    <span class="text-sm transition-transform duration-300" id="arrow">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </div>
            </div>
            <div id="submenu" class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-900 dark:text-gray-100 overflow-hidden max-h-0 transition-all duration-300">
                <a href="?page=pinjam_rpl1" class="block">
                    <div class="flex items-center cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md mt-1">
                        <i class="bi bi-bar-chart text-gray-700 dark:text-gray-300"></i>
                        <h1 class="ml-4">Lab RPL 1</h1>
                    </div>
                </a>
                <a href="?page=pinjam_rpl2" class="block">
                    <div class="flex items-center cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md mt-1">
                        <i class="bi bi-bar-chart text-gray-700 dark:text-gray-300"></i>
                        <h1 class="ml-4">Lab RPL 2</h1>
                    </div>
                </a>
                <a href="?page=pinjam_labmm" class="block">
                    <div class="flex items-center cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md mt-1">
                        <i class="bi bi-bar-chart text-gray-700 dark:text-gray-300"></i>
                        <h1 class="ml-4">Lab MM</h1>
                    </div>
                </a>
            </div>
            <a href="../logout.php" class="block mt-auto">
                <div class="py-2.5 flex items-center rounded-md px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700">
                    <i class="bi bi-box-arrow-in-right text-gray-700 dark:text-gray-300"></i>
                    <span class="text-[18px] ml-4">Logout</span>
                </div>
            </a>
        </div>
    </div>

    <div class="pt-16 lg:ml-[320px] min-h-[calc(100vh-64px)]">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 p-6">
            <a href="?page=pinjam_rpl1" class="block">
                <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition-transform duration-300 hover:scale-105 active:scale-100 hover:shadow-2xl">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="bi bi-building mr-2 text-gray-700 dark:text-gray-300"></i> Lab RPL 1
                        </h3>
                        <?php
                        include "../inc/koneksi.php";
                        $query = mysqli_query($conn, "SELECT nomor_laptop FROM lab_rpl1");
                        $row = mysqli_num_rows($query);
                        ?>
                        <h1 class="text-lg font-semibold bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-1 rounded-lg shadow-md">
                            <?php echo $row; ?>
                        </h1>
                    </div>
                    <p>Data barang ada di sini!</p>
                </div>
            </a>
            <a href="?page=pinjam_rpl2" class="block">
                <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition-transform duration-300 hover:scale-105 active:scale-100 hover:shadow-2xl">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="bi bi-building mr-2 text-gray-700 dark:text-gray-300"></i> Lab RPL 2
                        </h3>
                        <?php
                        include "../inc/koneksi.php";
                        $query = mysqli_query($conn, "SELECT nomor_laptop FROM lab_rpl2");
                        $row = mysqli_num_rows($query);
                        ?>
                        <h1 class="text-lg font-semibold bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-1 rounded-lg shadow-md">
                            <?php echo $row; ?>
                        </h1>
                    </div>
                    <p>Data barang ada di sini!</p>
                </div>
            </a>
            <a href="?page=pinjam_labmm" class="block">
                <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition-transform duration-300 hover:scale-105 active:scale-100 hover:shadow-2xl">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="bi bi-building mr-2 text-gray-700 dark:text-gray-300"></i> Lab MM
                        </h3>
                        <?php
                        include "../inc/koneksi.php";
                        $query = mysqli_query($conn, "SELECT nama_barang FROM lab_mm");
                        $row = mysqli_num_rows($query);
                        ?>
                        <h1 class="text-lg font-semibold bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-1 rounded-lg shadow-md">
                            <?php echo $row; ?>
                        </h1>
                    </div>
                    <p>Data barang ada di sini!</p>
                </div>
            </a>
        </div>

        <div class="grid gap-6 p-6">
            <div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 p-6 rounded-2xl 
            shadow-lg border border-gray-200 dark:border-gray-700 min-h-[470px] flex flex-col justify-center items-center">
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    switch ($page) {
                        case 'pinjam_rpl1':
                            include "../petugas/Lab_RPL_1/pinjam_rpl1.php";
                            break;
                        case 'pinjam_rpl2':
                            include "../petugas/Lab_RPL_2/pinjam_rpl2.php";
                            break;
                        case 'pinjam_labmm':
                            include "../petugas/Lab_MM/pinjam_mm.php";
                            break;
                        case 'kelola_users':
                            include "../petugas/kelola_users.php";
                            break;
                        case 'histori_peminjaman':
                            include "../siswa/histori_peminjaman.php";
                            break;
                        default:
                            echo "<h2 class='text-xl font-bold text-center'>Selamat Datang di Dashboard Petugas</h2>";
                            echo "<p class='text-center text-gray-600 dark:text-gray-300'>Pilih salah satu menu di atas untuk melihat data.</p>";
                            break;
                    }
                } else {
                    echo "<h2 class='text-xl font-bold text-center'>Selamat Datang di Dashboard Petugas</h2>";
                    echo "<p class='text-center text-gray-600 dark:text-gray-300'>Pilih salah satu menu di atas untuk melihat data.</p>";
                }
                ?>
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

        function dropdown() {
            let submenu = document.querySelector('#submenu');
            let arrow = document.querySelector('#arrow');
            if (submenu.classList.contains('max-h-0')) {
                submenu.classList.remove('max-h-0');
                submenu.classList.add('max-h-screen');
            } else {
                submenu.classList.remove('max-h-screen');
                submenu.classList.add('max-h-0');
            }
            arrow.classList.toggle('rotate-90');
        }

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