<?php
session_start();
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Proses hapus data
    // Catatan: Karena di database kita pakai ON DELETE CASCADE, 
    // transaksi yang pakai kategori ini akan otomatis terhapus juga.
    $query = "DELETE FROM kategori WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php?pesan=hapus_sukses");
    } else {
        header("Location: index.php?pesan=gagal");
    }
} else {
    header("Location: index.php");
}
exit;
?>