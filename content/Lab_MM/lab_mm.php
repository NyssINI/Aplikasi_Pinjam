<?php
include '../inc/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Laptop di Lab MM</title>
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
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

<body class="bg-gray-100 dark:bg-gray-900 font-serif transition-colors duration-300">
  <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">
    Daftar Laptop di Lab MM
  </h2>
  <div class="w-full h-full rounded-2xl p-6 flex flex-col">
    <!-- Tambahkan max-h-[calc(100vh-150px)] untuk menetapkan tinggi maksimum -->
    <div class="flex-grow overflow-auto max-w-full max-h-[calc(100vh-150px)]">
      <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
        <thead>
          <tr class="bg-gray-600 dark:bg-gray-700 text-white">
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[80px]">No</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[300px]">Nama Barang</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[300px]">Status</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[80px]">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM lab_mm ORDER BY nama_barang ASC";
          $result = mysqli_query($conn, $query);
          $no = 1;
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr class='text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition'>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $no++ . "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $row['nama_barang'] . "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2 text-green-600 font-semibold'>" . $row['status'] . "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2 flex justify-center gap-2'>";
              echo "<button onclick='editBarang(" . $row['id'] . ")' class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition'>Edit</button>";
              echo "<button onclick='hapusBarang(" . $row['id'] . ")' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition'>Delete</button>";
              echo "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr class='text-center'>";
            echo "<td colspan='4' class='border border-gray-300 dark:border-gray-600 p-4 text-gray-500 font-semibold'>Belum ada barang di Lab MM</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function hapusBarang(id) {
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
          window.location.href = "?page=hapus_mm&id=" + id;
        }
      });
    }

    function editBarang(id) {
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
          window.location.href = "?page=edit_mm&id=" + id;
        }
      });
    }
  </script>
</body>

</html>