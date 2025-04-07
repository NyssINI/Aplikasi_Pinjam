<?php
include '../inc/koneksi.php';

$role_siswa = "siswa";

$query = "INSERT INTO users (role) VALUES ('$role_siswa')";

if (mysqli_query($conn, $query)) {
    echo "Akun siswa berhasil ditambahkan!";
} else {
    echo "Gagal menambahkan akun siswa: " . mysqli_error($conn);
}
?>
