<?php
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "db_keuangan_mahasiswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// ==========================================
// TAMBAHKAN KODE INI DI BAWAH KONEKSI
// Sesuaikan dengan nama folder project kamu di htdocs
// ==========================================
define('BASE_URL', 'http://localhost/KEUANGAN_MAHASISWA/');
?>