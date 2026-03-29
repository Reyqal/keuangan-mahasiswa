<?php
session_start();
// Sesuaikan path jika koneksi.php ada di dalam folder config
include '../config/koneksi.php'; 

// Mencegah SQL Injection dasar
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']); // Mengenkripsi inputan untuk dicocokkan dengan database

// Cek kecocokan data
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);
    
    // Buat session
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['username'] = $data['username'];
    
    // Arahkan ke dashboard
    header("Location: ../index.php");
} else {
    // Jika salah, kembalikan ke halaman login dengan pesan gagal
    header("Location: login.php?pesan=gagal");
}
?>