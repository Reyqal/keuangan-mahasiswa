<?php
session_start();
include '../config/koneksi.php';

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id']; // Proteksi tambahan agar user hanya bisa hapus datanya sendiri

    // Proses hapus data
    $query = "DELETE FROM transaksi WHERE id = '$id' AND user_id = '$user_id'";
    
    if (mysqli_query($koneksi, $query)) {
        // Kembali ke halaman transaksi dengan pesan sukses
        header("Location: index.php?pesan=hapus_sukses");
    } else {
        // Kembali dengan pesan gagal
        header("Location: index.php?pesan=gagal");
    }
} else {
    // Jika diakses langsung tanpa ID
    header("Location: index.php");
}
exit;
?>