<?php
include '../config/koneksi.php';
include '../layouts/header.php';

$user_id = $_SESSION['user_id'];

// Ambil data transaksi beserta nama kategorinya (pakai JOIN)
$query = "SELECT t.*, k.nama_kategori 
          FROM transaksi t 
          JOIN kategori k ON t.kategori_id = k.id 
          WHERE t.user_id = '$user_id' 
          ORDER BY t.tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Riwayat Transaksi</h3>
        <p class="text-muted mb-0">Kelola semua catatan pemasukan dan pengeluaranmu.</p>
    </div>
    <a href="tambah.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="fas fa-plus me-2"></i> Tambah Data
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-5">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle tabel-data" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center rounded-start">No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Catatan</th>
                        <th>Jenis</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-center rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)) : 
                    ?>
                    <tr>
                        <td class="text-center text-muted"><?= $no++; ?></td>
                        <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                        <td><span class="fw-medium text-dark"><?= $row['nama_kategori']; ?></span></td>
                        <td class="text-muted"><?= $row['catatan'] ? $row['catatan'] : '-'; ?></td>
                        <td>
                            <?php if($row['jenis'] == 'pemasukan'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-arrow-down me-1"></i> Pemasukan
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="fas fa-arrow-up me-1"></i> Pengeluaran
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end fw-bold <?= $row['jenis'] == 'pemasukan' ? 'text-success' : 'text-danger'; ?>">
                            Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?>
                        </td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="hapusData(<?= $row['id']; ?>)" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
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
    function hapusData(id) {
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
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
// Menangkap pesan notifikasi dari tambah/edit/hapus
if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == "tambah_sukses") {
        echo "<script>Swal.fire('Berhasil!', 'Data transaksi berhasil ditambahkan.', 'success');</script>";
    } else if ($_GET['pesan'] == "edit_sukses") {
        echo "<script>Swal.fire('Berhasil!', 'Data transaksi berhasil diperbarui.', 'success');</script>";
    } else if ($_GET['pesan'] == "hapus_sukses") {
        echo "<script>Swal.fire('Terhapus!', 'Data transaksi berhasil dihapus.', 'success');</script>";
    } else if ($_GET['pesan'] == "gagal") {
        echo "<script>Swal.fire('Oops!', 'Terjadi kesalahan pada sistem.', 'error');</script>";
    }
}

include '../layouts/footer.php'; 
?>