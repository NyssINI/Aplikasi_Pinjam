<?php
session_start();
include '../inc/koneksi.php';

$username   = mysqli_real_escape_string($conn, $_POST['username']);
$credential = mysqli_real_escape_string($conn, $_POST['credential']); 

echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$data  = mysqli_fetch_assoc($query);

if ($data) {
    // Jika user sudah ada, cek role
    if ($data['role'] == 'admin' || $data['role'] == 'petugas') {
        // Untuk admin dan petugas, gunakan verifikasi password
        if (password_verify($credential, $data['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role']     = ucfirst($data['role']);
            $redirect = ($data['role'] == 'admin') ? '../Admin/dashboard_admin.php' : '../Petugas/dashboard_petugas.php';
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'SELAMAT!',
                        text: 'Login Berhasil',
                        icon: 'success',
                        background: '#2d3748',
                        color: '#fff',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location = '$redirect';
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        text: 'Username atau password salah.',
                        background: '#2d3748',
                        color: '#fff',
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        window.location = '../index.php';
                    });
                });
            </script>";
        }
    } elseif (strtolower($data['role']) == 'siswa') {
        $_SESSION['username'] = $username;
        $_SESSION['role']     = 'Siswa';
        $updateNis = mysqli_query($conn, "UPDATE users SET nis='$credential' WHERE username='$username'");
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'SELAMAT!',
                    text: 'Login Berhasil',
                    icon: 'success',
                    background: '#2d3748',
                    color: '#fff',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location = '../siswa/dashboard_siswa.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!',
                    text: 'Role tidak valid.',
                    background: '#2d3748',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    window.location = '../index.php';
                });
            });
        </script>";
    }
} else {
    $insert = mysqli_query($conn, "INSERT INTO users (username, role, nis) VALUES ('$username', 'siswa', '$credential')");
    if ($insert) {
        $_SESSION['username'] = $username;
        $_SESSION['role']     = 'Siswa';
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'SELAMAT!',
                    text: 'Login Berhasil. Akun siswa telah dibuat.',
                    icon: 'success',
                    background: '#2d3748',
                    color: '#fff',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location = '../siswa/dashboard_siswa.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!',
                    text: 'Terjadi kesalahan saat membuat akun siswa.',
                    background: '#2d3748',
                    color: '#fff',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    window.location = '../index.php';
                });
            });
        </script>";
    }
}
?>
