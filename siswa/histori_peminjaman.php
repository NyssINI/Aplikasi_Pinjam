<?php
require '../inc/koneksi.php';

$lab_filter  = isset($_POST['lab_filter']) ? $_POST['lab_filter'] : 'all';
$date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : date('Y-m-d');

$conditions = [];
if ($lab_filter != 'all') {
  $conditions[] = "lab = '" . mysqli_real_escape_string($conn, $lab_filter) . "'";
}

if (!empty($date_filter)) {
  $conditions[] = "DATE(jam_pinjam) = '$date_filter'";
}

$where_clause = count($conditions) > 0 ? "WHERE " . implode(" AND ", $conditions) : "";

$query  = "SELECT * FROM histori_peminjaman $where_clause ORDER BY nama_peminjam DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Histori Peminjaman</title>
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
  <style>
    html, body {
      transition: background-color 0.3s, color 0.3s;
    }
  </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-serif transition-colors duration-300">
  <h2 class="text-[25px] font-bold text-center my-auto pt-4 text-gray-900 dark:text-gray-100">
    Histori Peminjaman
  </h2>
  <div class="w-full h-[calc(100vh-200px)] rounded-2xl p-6 flex flex-col bg-white dark:bg-gray-800 relative">
    <!-- Filter Form & Tombol Print -->
    <div class="mb-4 flex flex-wrap items-end gap-4 no-print">
      <form method="post" action="" class="flex flex-wrap items-end gap-4 w-full md:w-auto">
        <div class="w-full md:w-auto">
          <label class="block font-medium">Pilih Lab:</label>
          <select name="lab_filter" class="w-full md:w-auto p-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
            <option value="all" <?= ($lab_filter == 'all') ? 'selected' : '' ?>>Semua Lab</option>
            <option value="MM" <?= ($lab_filter == 'MM') ? 'selected' : '' ?>>Lab MM</option>
            <option value="RPL 1" <?= ($lab_filter == 'RPL 1') ? 'selected' : '' ?>>Lab RPL 1</option>
            <option value="RPL 2" <?= ($lab_filter == 'RPL 2') ? 'selected' : '' ?>>Lab RPL 2</option>
          </select>
        </div>
        <div class="w-full md:w-auto">
          <label class="block font-medium">Pilih Tanggal:</label>
          <input type="date" name="date_filter" value="<?= htmlspecialchars($date_filter) ?>" class="w-full md:w-auto p-2 border rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>
        <div class="w-full md:w-auto">
          <button type="submit" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Filter</button>
        </div>
      </form>
      <div class="w-full md:w-auto">
        <button type="button" onclick="printTable()" class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
          <i class="bi bi-printer"></i> Print Tabel
        </button>
      </div>
    </div>

    <div id="printableTable" class="overflow-x-auto">
  <table class="w-full table-fixed border-collapse border border-gray-300 dark:border-gray-600">
    <thead>
      <tr class="bg-gray-600 dark:bg-gray-700 text-white">
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-1/12">No</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Nama Peminjam</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Kelas</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Jam Pinjam</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Jam Kembali</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Status</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Nomor Laptop</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-2/12">Nama Barang</th>
        <th class="border border-gray-300 dark:border-gray-600 p-2 break-words w-1/12">Lab</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <?php
          if ($row['lab'] == 'MM') {
            $row['nomor_laptop'] = '-';
          } elseif ($row['lab'] == 'RPL 1' || $row['lab'] == 'RPL 2') {
            $row['nama_barang'] = '-';
          }
          ?>
          <tr class="text-center hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= $no++ ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['nama_peminjam']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['kelas']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['jam_pinjam']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['jam_kembali']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['status']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['nomor_laptop']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['nama_barang']) ?></td>
            <td class="border border-gray-300 dark:border-gray-600 p-2 break-words"><?= htmlspecialchars($row['lab']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="9" class="text-center py-4">Tidak ada data histori peminjaman untuk filter yang dipilih.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

  <!-- Script untuk Print dan Sidebar -->
  <script>
    function printTable() {
      var tableContent = document.getElementById("printableTable").innerHTML;
      var printWindow = window.open('', '', 'height=600,width=800');
      printWindow.document.write('<html><head><title>Print Tabel Histori Peminjaman</title>');
      printWindow.document.write('<link rel="stylesheet" href="https://cdn.tailwindcss.com">');
      printWindow.document.write('<style>body{font-family: sans-serif; margin: 20px;}</style>');
      printWindow.document.write('</head><body>');
      printWindow.document.write(tableContent);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    }

    function Open() {
      let sidebar = document.querySelector('.sidebar');
      sidebar.classList.remove('-left-72');
      sidebar.classList.add('left-0');
      document.getElementById('burger-btn').classList.add('hidden');
    }

    function Close() {
      let sidebar = document.querySelector('.sidebar');
      sidebar.classList.remove('left-0');
      sidebar.classList.add('-left-72');
      document.getElementById('burger-btn').classList.remove('hidden');
    }
  </script>
</body>
</html>
