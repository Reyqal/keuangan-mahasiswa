<?php
// ajax_tambah_kategori.php
include '../config/koneksi.php';

if(isset($_POST['nama_kategori'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
    
    if (mysqli_query($koneksi, $query)) {
        // Ambil ID yang baru saja masuk
        $id_baru = mysqli_insert_id($koneksi);
        
        // Kembalikan data dalam format JSON
        echo json_encode([
            'status' => 'success', 
            'id' => $id_baru, 
            'nama_kategori' => $nama_kategori
        ]);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Gagal menyimpan ke database.']);
    }
}
?>