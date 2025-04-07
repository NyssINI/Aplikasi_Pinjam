<?php
include '../inc/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pinjam'])) {
  $nama_barang    = $_POST['nama_barang'] ?? null;
  $nama_peminjam  = $_POST['nama_peminjam'];
  $kelas          = $_POST['kelas'];
  $jam_pinjam     = $_POST['jam_pinjam'];
  $jam_kembali    = $_POST['jam_kembali'];
  $jam_pinjam  = str_replace("T", " ", $jam_pinjam) . ":00";
  $jam_kembali = str_replace("T", " ", $jam_kembali) . ":00";

  if (!empty($nama_barang)) {
    $update_status = "UPDATE lab_mm SET status='Dipinjam' WHERE nama_barang='$nama_barang'";
    mysqli_query($conn, $update_status);

    $insert_histori = "INSERT INTO histori_peminjaman (nama_peminjam, kelas, jam_pinjam, jam_kembali, status, nama_barang, lab) 
      VALUES ('$nama_peminjam', '$kelas', '$jam_pinjam', '$jam_kembali', 'Dipinjam', '$nama_barang', 'MM')";
    mysqli_query($conn, $insert_histori);
  }
}

if (isset($_GET['selesai']) && isset($_GET['nama_barang'])) {
  $nama_barang = $_GET['nama_barang'];

  $update_status = "UPDATE lab_mm SET status='Tersedia' WHERE nama_barang='$nama_barang'";
  if (!mysqli_query($conn, $update_status)) {
    die("Error Update Status: " . mysqli_error($conn));
  }

  $update_histori = "UPDATE histori_peminjaman SET status='Dikembalikan' WHERE nama_barang='$nama_barang' AND status='Dipinjam'";
  if (!mysqli_query($conn, $update_histori)) {
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
              window.location.href='?page=pinjam_labmm';
          });
      });
  </script>";
  exit();
}

$query  = "SELECT * FROM lab_mm ORDER BY nama_barang ASC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Barang di Lab MM</title>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    html,
    body {
      transition: background-color 0.3s, color 0.3s;
    }
  </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-serif transition-colors duration-300">
  <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">
    Daftar Barang di Lab MM
  </h2>
  <div class="w-full h-full rounded-2xl p-6 flex flex-col">
    <div class="flex-grow overflow-auto max-w-full max-h-[calc(100vh-120px)]">
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
          $no = 1;
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='text-center bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition'>";
            echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $no++ . "</td>";
            echo "<td class='border border-gray-300 dark:border-gray-600 p-2'>" . $row['nama_barang'] . "</td>";
            echo "<td class='border border-gray-300 dark:border-gray-600 p-2 text-green-600 font-semibold'>" . $row['status'] . "</td>";
            echo "<td class='border border-gray-300 dark:border-gray-600 p-2 flex justify-center gap-2'>";
            if ($row['status'] == "Tersedia") {
              echo "<button onclick=\"showForm('" . $row['nama_barang'] . "')\" 
              class='bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition'>Pinjam</button>";
            } else {
              echo "<a href='?page=pinjam_labmm&selesai&nama_barang=" . $row['nama_barang'] . "' 
              class='bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition'>Selesai</a>";
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
        <input type="hidden" name="nama_barang" id="nama_barang">
        <label class="text-gray-900 dark:text-gray-100">Nama Peminjam:</label>
        <input type="text" name="nama_peminjam" required class="border p-2 w-full mb-2 bg-white dark:bg-gray-700">
        <label class="text-gray-900 dark:text-gray-100">Kelas:</label>
        <input type="text" name="kelas" required class="border p-2 w-full mb-2 bg-white dark:bg-gray-700">
        <label class="text-gray-900 dark:text-gray-100">Jam Peminjaman:</label>
        <input type="datetime-local" name="jam_pinjam" required class="border p-2 w-full mb-2 bg-white dark:bg-gray-700">
        <label class="text-gray-900 dark:text-gray-100">Jam Pengembalian:</label>
        <input type="datetime-local" name="jam_kembali" required class="border p-2 w-full mb-4 bg-white dark:bg-gray-700">
        <div class="flex justify-end gap-2">
          <button type="button" onclick="closeForm()" class="bg-gray-500 text-white px-3 py-1 rounded">Batal</button>
          <button type="submit" name="pinjam" class="bg-blue-500 text-white px-3 py-1 rounded">Pinjam</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function showForm(namaBarang) {
      document.getElementById('nama_barang').value = namaBarang;
      document.getElementById('formPinjam').classList.remove('hidden');
    }

    function closeForm() {
      document.getElementById('formPinjam').classList.add('hidden');
    }

    function showForm(namaBarang) {
      document.getElementById('nama_barang').value = namaBarang;
      document.getElementById('formPinjam').classList.remove('hidden');
    }

    function closeForm() {
      document.getElementById('formPinjam').classList.add('hidden');
    }
  </script>
</body>
</html>