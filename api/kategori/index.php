<?php
include '../config/koneksi.php';
include '../layouts/header.php';

// Ambil semua data kategori
$query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Kelola Kategori</h3>
        <p class="text-muted mb-0">Tambah, ubah, atau hapus kategori transaksimu.</p>
    </div>
    <a href="tambah.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i> Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-5">
    <div class="card-body p-4">
        <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning-emphasis d-flex align-items-center rounded-3 mb-4" role="alert">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <strong>Perhatian!</strong> Jika kamu menghapus sebuah kategori, <b>semua riwayat transaksi</b> yang menggunakan kategori tersebut juga akan ikut terhapus secara otomatis.
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle tabel-data" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center rounded-start" width="10%">No</th>
                        <th>Nama Kategori</th>
                        <th class="text-center rounded-end" width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($query)) : 
                    ?>
                    <tr>
                        <td class="text-center text-muted"><?= $no++; ?></td>
                        <td class="fw-medium text-dark"><?= $row['nama_kategori']; ?></td>
                        <td class="text-center">
                            <a href="kategori/edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="hapusKategori(<?= $row['id']; ?>)" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function hapusKategori(id) {
        Swal.fire({
            title: 'Hapus kategori ini?',
            text: "Awas! Semua transaksi dengan kategori ini juga akan terhapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'hapus.php?id=' + id;
            }
        })
    }
</script>

<?php 
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == "tambah_sukses") echo "<script>Swal.fire('Berhasil!', 'Kategori baru berhasil ditambahkan.', 'success');</script>";
    else if ($_GET['pesan'] == "edit_sukses") echo "<script>Swal.fire('Berhasil!', 'Nama kategori berhasil diperbarui.', 'success');</script>";
    else if ($_GET['pesan'] == "hapus_sukses") echo "<script>Swal.fire('Terhapus!', 'Kategori dan transaksinya berhasil dihapus.', 'success');</script>";
    else if ($_GET['pesan'] == "gagal") echo "<script>Swal.fire('Oops!', 'Terjadi kesalahan sistem.', 'error');</script>";
}

include '../layouts/footer.php'; 
?>