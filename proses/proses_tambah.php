<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Barang</title>
  <script>
    if (localStorage.getItem('theme') === 'dark') {
      document.documentElement.classList.add('dark');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
</body>
</html>
<?php
include '../inc/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lokasi = mysqli_real_escape_string($conn, $_POST["lokasi"]);

    if ($lokasi == "Lab RPL 1" || $lokasi == "Lab RPL 2") {
        $table = ($lokasi == "Lab RPL 1") ? "lab_rpl1" : "lab_rpl2";
        $nomor_laptop = mysqli_real_escape_string($conn, $_POST["nomor_laptop"]);
        $mouse = isset($_POST["mouse"]) ? 1 : 0;
        $charger = isset($_POST["charger"]) ? 1 : 0;
        $headset = isset($_POST["headset"]) ? 1 : 0;

        $cek_query = "SELECT * FROM $table WHERE nomor_laptop = '$nomor_laptop'";
        $cek_result = mysqli_query($conn, $cek_query);

        if (mysqli_num_rows($cek_result) > 0) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const isDark = document.documentElement.classList.contains('dark');
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Nomor Laptop sudah ada di $lokasi! Silakan masukkan nomor lain.',
                            customClass: {
                                popup: isDark ? 'bg-gray-800 text-white' : 'bg-white text-black'
                            },
                            confirmButtonColor: '#d33'
                        }).then(() => {
                            window.location.href = '../admin/dashboard_admin.php?page=tambah_barang';
                        });
                    });
                  </script>";
            exit;
        }
        $sql = "INSERT INTO $table (nomor_laptop, status, mouse, charger, headset) 
                VALUES ('$nomor_laptop', 'Tersedia', '$mouse', '$charger', '$headset')";
    } elseif ($lokasi == "Lab MM") {
        $nama_barang = mysqli_real_escape_string($conn, $_POST["nama_barang"]);
        $sql = "INSERT INTO lab_mm (nama_barang, status) VALUES ('$nama_barang', 'Tersedia')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const isDark = document.documentElement.classList.contains('dark');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Barang berhasil ditambahkan ke $lokasi!',
                        customClass: {
                            popup: isDark ? 'bg-gray-800 text-white' : 'bg-white text-black'
                        },
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location.href = '../admin/dashboard_admin.php?page=tambah_barang';
                    });
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const isDark = document.documentElement.classList.contains('dark');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan: " . mysqli_error($conn) . "',
                        customClass: {
                            popup: isDark ? 'bg-gray-800 text-white' : 'bg-white text-black'
                        },
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        window.location.href = '../admin/dashboard_admin.php?page=tambah_barang';
                    });
                });
              </script>";
    }
}
?>
