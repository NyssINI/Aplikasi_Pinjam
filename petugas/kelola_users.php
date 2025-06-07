<h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">Tambah Siswa</h2>
<form action="" method="post" class="space-y-4 w-full max-w-md">
    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" 
        class="w-full px-4 py-2 border rounded bg-white text-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-700" required>
    <input type="text" name="nis" placeholder="NIS" 
        class="w-full px-4 py-2 border rounded bg-white text-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-700" required>
    <input type="text" name="username" placeholder="Username" 
        class="w-full px-4 py-2 border rounded bg-white text-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-700" required>
    <input type="text" name="kelas" placeholder="Kelas" 
        class="w-full px-4 py-2 border rounded bg-white text-gray-800 dark:bg-gray-800 dark:text-white dark:border-gray-700" required>
    
    <button type="submit" name="tambah" 
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
        Tambah
    </button>
</form>

<?php
include "../inc/koneksi.php";

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_lengkap'];
    $nis = $_POST['nis'];
    $username = $_POST['username'];
    $kelas = $_POST['kelas'];

    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<p class='text-red-600 dark:text-red-400 mt-4'>Username sudah digunakan!</p>";
    } else {
        $query = mysqli_query($conn, "INSERT INTO siswa (nama_lengkap, nis, username, kelas, role) VALUES ('$nama', '$nis', '$username', '$kelas', 'Siswa')");
        if ($query) {
            echo "<p class='text-green-600 dark:text-green-400 mt-4'>Siswa berhasil ditambahkan!</p>";
        } else {
            echo "<p class='text-red-600 dark:text-red-400 mt-4'>Gagal menambahkan siswa.</p>";
        }
    }
}
?>
