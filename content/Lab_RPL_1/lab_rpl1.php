<?php
include '../inc/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Laptop di Lab RPL 1</title>
  <!-- Set dark mode sebelum render -->
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  </script>
  <!-- Include Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- Transisi Global -->
  <style>
    html, body {
      transition: background-color 0.3s, color 0.3s;
    }
  </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-serif transition-colors duration-300">
  <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">
    Daftar Laptop di Lab RPL 1
  </h2>
  <!-- Container Utama dengan Tinggi Tetap dan Scroll -->
  <div class="w-full h-[calc(100vh-200px)] rounded-2xl p-6 flex flex-col bg-white dark:bg-gray-800">
    <!-- Area Tabel dengan Scroll Internal -->
    <div class="flex-grow overflow-y-auto">
      <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
        <thead>
          <tr class="bg-gray-600 dark:bg-gray-700 text-white">
            <th class="border border-gray-300 dark:border-gray-600 p-2">No</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[200px]">Nomor Laptop</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">Status</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">Kelengkapan</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[80px]">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $query = "SELECT * FROM lab_rpl1 ORDER BY nomor_laptop ASC";
            $result = mysqli_query($conn, $query);
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition'>";
                  echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $no++ . "</td>";
                  echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $row['nomor_laptop'] . "</td>";
                  echo "<td class='border border-gray-300 dark:border-gray-600 p-2 text-green-600 font-semibold'>" . $row['status'] . "</td>";
                  echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>";
                    $kelengkapan = [];
                    if ($row['mouse'])   $kelengkapan[] = "Mouse";
                    if ($row['charger']) $kelengkapan[] = "Charger";
                    if ($row['headset']) $kelengkapan[] = "Headset";
                    echo !empty($kelengkapan) ? implode(", ", $kelengkapan) : "-";
                  echo "</td>";
                  echo "<td class='border border-gray-300 dark:border-gray-600 p-2 flex justify-center gap-2'>";
                    echo "<button onclick='editLaptop(" . $row['id'] . ")' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition'>Edit</button>";
                    echo "<button onclick='hapusLaptop(" . $row['id'] . ")' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition'>Delete</button>";
                  echo "</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr class='text-center'>";
                echo "<td colspan='5' class='border border-gray-300 dark:border-gray-600 p-4 text-gray-500 font-semibold'>Belum ada barang di Lab RPL 1</td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function hapusLaptop(id) {
      const isDark = document.documentElement.classList.contains('dark');
      Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: isDark ? '#3085d6' : '#3085d6',
        cancelButtonColor: isDark ? '#d33' : '#d33',
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        background: isDark ? '#2d3748' : '#fff',
        color: isDark ? '#fff' : '#000'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "?page=hapus_rpl1&id=" + id;
        }
      });
    }

    function editLaptop(id) {
      const isDark = document.documentElement.classList.contains('dark');
      Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "Anda akan mengedit data laptop ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: isDark ? '#3085d6' : '#3085d6',
        cancelButtonColor: isDark ? '#d33' : '#d33',
        confirmButtonText: "Ya, Edit!",
        cancelButtonText: "Batal",
        background: isDark ? '#2d3748' : '#fff',
        color: isDark ? '#fff' : '#000'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "?page=edit_rpl1&id=" + id;
        }
      });
    }
  </script>
</body>
</html>
