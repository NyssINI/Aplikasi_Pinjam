<?php
include '../inc/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pinjam'])) {
  $nomor_laptop = $_POST['nomor_laptop'] ?? null;
  $nama_peminjam = $_POST['nama_peminjam'];
  $kelas         = $_POST['kelas'];
  $jam_pinjam    = $_POST['jam_pinjam'];
  $jam_kembali   = $_POST['jam_kembali'];

  if (!empty($nomor_laptop)) {
    mysqli_query($conn, "UPDATE lab_rpl2 SET status='Dipinjam' WHERE nomor_laptop='$nomor_laptop'");

    mysqli_query($conn, "INSERT INTO histori_peminjaman (nama_peminjam, kelas, jam_pinjam, jam_kembali, status, nomor_laptop, lab) 
      VALUES ('$nama_peminjam', '$kelas', '$jam_pinjam', '$jam_kembali', 'Dipinjam', '$nomor_laptop', 'RPL 2')");
  }
}

if (isset($_GET['selesai']) && isset($_GET['nomor_laptop'])) {
  $nomor_laptop = $_GET['nomor_laptop'];

  if (!mysqli_query($conn, "UPDATE lab_rpl2 SET status='Tersedia' WHERE nomor_laptop='$nomor_laptop'")) {
    die("Error Update Status: " . mysqli_error($conn));
  }
  if (!mysqli_query($conn, "UPDATE histori_peminjaman SET status='Dikembalikan' WHERE nomor_laptop='$nomor_laptop' AND status='Dipinjam'")) {
    die("Error Update Histori: " . mysqli_error($conn));
  }
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
  echo "<script>
      document.addEventListener('DOMContentLoaded', function() {
          const isDark = document.documentElement.classList.contains('dark');
          Swal.fire({
              icon: 'success',
              title: 'Pengembalian berhasil!',
              background: isDark ? '#2d3748' : '#fff',
              color: isDark ? '#fff' : '#000'
          }).then(() => {
              window.location.href='?page=pinjam_rpl2';
          });
      });
  </script>";
  exit();
}

$query  = "SELECT * FROM lab_rpl2 ORDER BY nomor_laptop ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Laptop di Lab RPL 1</title>
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    html, body {
      transition: background-color 0.3s, color 0.3s;
    }
  </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-serif transition-colors duration-300">
  <h2 class="text-[25px] font-bold text-center pt-4 text-gray-900 dark:text-gray-100">
    Daftar Laptop di Lab RPL 2
  </h2>
  <div class="w-full h-full rounded-2xl p-6 flex flex-col">
    <div class="flex-grow overflow-auto max-w-full max-h-[calc(100vh-120px)]">
      <table class="w-full border-collapse border border-gray-300 dark:border-gray-600">
        <thead>
          <tr class="bg-gray-600 dark:bg-gray-700 text-white">
            <th class="border border-gray-300 dark:border-gray-600 p-2">No</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[200px]">Nomor Laptop</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">Status</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2">Kelengkapan</th>
            <th class="border border-gray-300 dark:border-gray-600 p-2 w-[150px]">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition'>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $no++ . "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $row['nomor_laptop'] . "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2 text-green-600 font-semibold'>" . $row['status'] . "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>";
                $kelengkapan = [];
                if ($row['mouse']) $kelengkapan[] = "Mouse";
                if ($row['charger']) $kelengkapan[] = "Charger";
                if ($row['headset']) $kelengkapan[] = "Headset";
                echo !empty($kelengkapan) ? implode(", ", $kelengkapan) : "-";
              echo "</td>";
              echo "<td class='border border-gray-300 dark:border-gray-600 p-2 flex justify-center gap-2'>";
                if ($row['status'] == "Tersedia") {
                  echo "<button onclick=\"showForm('" . $row['nomor_laptop'] . "')\" class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 dark:hover:bg-blue-700 transition'>Pinjam</button>";
                } else {
                  echo "<a href='?page=pinjam_rpl2&selesai&nomor_laptop=" . $row['nomor_laptop'] . "' class='bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 dark:hover:bg-green-700 transition'>Selesai</a>";
                }
              echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div id="formPinjam" class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
      <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Form Peminjaman</h2>
      <form method="POST">
        <input type="hidden" name="nomor_laptop" id="nomor_laptop">
        <label class="text-gray-900 dark:text-gray-100">Nama Peminjam:</label>
        <input type="text" name="nama_peminjam" required class="border p-2 w-full mb-2 bg-white dark:bg-gray-700">
        <label class="text-gray-900 dark:text-gray-100">Kelas:</label>
        <input type="text" name="kelas" required class="border p-2 w-full mb-2 bg-white dark:bg-gray-700">
        <label class="text-gray-900 dark:text-gray-100">Jam Peminjaman:</label>
        <input type="datetime-local" name="jam_pinjam" required class="border p-2 w-full mb-2 bg-white dark:bg-gray-700">
        <label class="text-gray-900 dark:text-gray-100">Jam Pengembalian:</label>
        <input type="datetime-local" name="jam_kembali" required class="border p-2 w-full mb-4 bg-white dark:bg-gray-700">
        <div class="flex justify-end gap-2">
          <button type="button" onclick="closeForm()" class="bg-gray-500 text-white px-3 py-1 rounded dark:hover:bg-gray-700 hover:bg-gray-600 transition">Batal</button>
          <button type="submit" name="pinjam" class="bg-blue-500 text-white px-3 py-1 rounded dark:hover:bg-blue-700 hover:bg-blue-600 transition">Pinjam</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function showForm(nomorLaptop) {
      document.getElementById('nomor_laptop').value = nomorLaptop;
      document.getElementById('formPinjam').classList.remove('hidden');
    }
    function closeForm() {
      document.getElementById('formPinjam').classList.add('hidden');
    }
  </script>
</body>
</html>
