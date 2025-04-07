<?php
include '../inc/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM lab_rpl1 WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    Swal.fire({
        title: 'Berhasil!',
        text: 'Laptop berhasil dihapus dari Lab RPL 1!',
        icon: 'success',
        background: isDark ? '#2d3748' : '#fff',
        color: isDark ? '#fff' : '#000',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    }).then(() => {
         window.location.href = '?page=lab_rpl1';
    });
});
</script>
</body>
</html>";
    } else {
        echo "<!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    Swal.fire({
        title: 'Gagal!',
        text: 'Gagal menghapus laptop!',
        icon: 'error',
        background: isDark ? '#2d3748' : '#fff',
        color: isDark ? '#fff' : '#000',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    }).then(() => {
         window.location.href = '?page=lab_rpl1';
    });
});
</script>
</body>
</html>";
    }
} else {
    echo "<!DOCTYPE html>
<html>
<head>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    Swal.fire({
        title: 'Error!',
        text: 'ID tidak ditemukan!',
        icon: 'error',
        background: isDark ? '#2d3748' : '#fff',
        color: isDark ? '#fff' : '#000',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    }).then(() => {
         window.location.href = '?page=lab_rpl1';
    });
});
</script>
</body>
</html>";
}
?>
