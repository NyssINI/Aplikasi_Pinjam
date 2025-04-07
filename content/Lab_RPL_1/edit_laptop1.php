<?php
include '../inc/koneksi.php';

$alert = ""; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM lab_rpl1 WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='?page=lab_rpl1';</script>";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nomor_laptop = $_POST['nomor_laptop'];
    $mouse = isset($_POST['mouse']) ? 1 : 0;
    $charger = isset($_POST['charger']) ? 1 : 0;
    $headset = isset($_POST['headset']) ? 1 : 0;    

    $updateQuery = "UPDATE lab_rpl1 SET nomor_laptop='$nomor_laptop', mouse=$mouse, charger=$charger, headset=$headset WHERE id=$id";
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
                    window.location = '?page=lab_rpl1';
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
  <title>Edit Laptop - Lab RPL1</title>
  <!-- Set dark mode sebelum render -->
  <script>
      if (localStorage.getItem('theme') === 'dark') {
          document.documentElement.classList.add('dark');
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
  <!-- Global Transition Style -->
  <style>
      html, body {
          transition: background-color 0.3s, color 0.3s;
      }
  </style>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100 dark:bg-gray-900">
  <!-- Container dengan ukuran dan tampilan yang sama seperti halaman Edit Lab RPL2 -->
  <div class="w-full h-full rounded-2xl p-6 flex flex-col">
      <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">Edit Data Laptop RPL1</h2>
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
</body>
</html>
