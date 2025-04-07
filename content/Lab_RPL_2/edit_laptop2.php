<?php
include '../inc/koneksi.php';

$alert = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM lab_rpl2 WHERE id = $id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='?page=lab_rpl2';</script>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nomor_laptop = $_POST['nomor_laptop'];
    $mouse = isset($_POST['mouse']) ? 1 : 0;
    $charger = isset($_POST['charger']) ? 1 : 0;
    $headset = isset($_POST['headset']) ? 1 : 0;

    $updateQuery = "UPDATE lab_rpl2 SET nomor_laptop='$nomor_laptop', mouse=$mouse, charger=$charger, headset=$headset WHERE id=$id";
    $update = $conn->query($updateQuery);

    if ($update) {
        $alert = "<script>
            document.addEventListener('DOMContentLoaded', function() {
              const isDark = document.documentElement.classList.contains('dark');
              Swal.fire({
                  title: 'Berhasil!',
                  text: 'Data berhasil diperbarui',
                  icon: 'success',
                  background: isDark ? '#2d3748' : '#fff',
                  color: isDark ? '#fff' : '#000'
                }).then(() => {
                    window.location = '?page=lab_rpl2';
                });
            });
        </script>";
    } else {
        $alert = "<script>
           document.addEventListener('DOMContentLoaded', function() {
              const isDark = document.documentElement.classList.contains('dark');
              Swal.fire({
                  icon: 'error',
                  title: 'Gagal!',
                  text: 'Terjadi kesalahan saat menyimpan data.',
                  background: isDark ? '#2d3748' : '#fff',
                  color: isDark ? '#fff' : '#000'
                });
            });
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laptop - Lab RPL2</title>
    <!-- Inline script: Set dark mode sebelum render -->
    <script>
        // Cek tema yang disimpan di localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Transisi global -->
    <style>
        html, body {
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>
<body class="flex justify-center items-center h-screen">
    <!-- Tombol Toggle Theme (opsional) -->
    <button onclick="toggleTheme()" class="fixed top-4 right-4 p-2 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors duration-300">
        <i id="icon-light" class="bi bi-sun-fill text-yellow-400"></i>
        <i id="icon-dark" class="bi bi-moon-fill text-gray-200 hidden"></i>
    </button>

    <div class="w-full h-full rounded-2xl p-6 flex flex-col">
        <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">Edit Data Laptop RPL2</h2>
        <div class="flex-grow overflow-auto max-w-full">
            <form method="post" action="" class="w-full">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                
                <label class="block mb-2 text-gray-900 dark:text-gray-100">Nomor Laptop:</label>
                <input type="text" name="nomor_laptop" value="<?php echo $row['nomor_laptop']; ?>" required
                       class="w-full p-2 border rounded mb-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 transition-colors duration-300">
                
                <label class="block mb-2 text-gray-900 dark:text-gray-100">Kelengkapan:</label>
                <div class="flex items-center gap-3 mb-3">
                    <label class="text-gray-900 dark:text-gray-100">
                        <input type="checkbox" name="mouse" value="1" class="text-blue-500" <?php if($row['mouse']) echo 'checked'; ?>> Mouse
                    </label>
                    <label class="text-gray-900 dark:text-gray-100">
                        <input type="checkbox" name="charger" value="1" class="text-blue-500" <?php if($row['charger']) echo 'checked'; ?>> Charger
                    </label>
                    <label class="text-gray-900 dark:text-gray-100">
                        <input type="checkbox" name="headset" value="1" class="text-blue-500" <?php if($row['headset']) echo 'checked'; ?>> Headset
                    </label>
                </div>
                
                <button type="submit" name="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition-colors duration-300">Simpan</button>
                <button type="reset" class="w-full bg-gray-300 text-black py-2 rounded mt-2 hover:bg-gray-400 transition-colors duration-300">Reset</button>
            </form>
        </div>
    </div>
    <?php echo $alert; ?>

    <!-- Script untuk Toggle Dark Mode -->
    <script>
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
