<?php
include '../config/koneksi.php';
include '../layouts/header.php';

$user_id = $_SESSION['user_id'];

// Ambil data transaksi yang mau diedit berdasarkan ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = '$id' AND user_id = '$user_id'");
    $data = mysqli_fetch_assoc($query_data);
    
    // Jika datanya tidak ada atau bukan milik user tersebut, tendang balik
    if (!$data) {
        echo "<script>window.location.href = 'index.php';</script>";
        exit;
    }
}

// Menangkap proses update ketika form disubmit
if (isset($_POST['update'])) {
    $id_transaksi = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $kategori_id = $_POST['kategori_id'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);

    // Proses update ke database
    $query_update = "UPDATE transaksi SET 
                     kategori_id = '$kategori_id', 
                     tanggal = '$tanggal', 
                     jenis = '$jenis', 
                     jumlah = '$jumlah', 
                     catatan = '$catatan' 
                     WHERE id = '$id_transaksi' AND user_id = '$user_id'";
    
    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>window.location.href = 'index.php?pesan=edit_sukses';</script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');
            });
        </script>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">Edit Transaksi</h3>
                <p class="text-muted mb-0">Perbarui catatan keuanganmu di sini.</p>
            </div>
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body p-5">
                <form action="" method="POST" id="formEdit">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control rounded-3" value="<?= $data['tanggal']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Transaksi <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-select rounded-3">
                                <option value="pemasukan" <?= ($data['jenis'] == 'pemasukan') ? 'selected' : ''; ?>>Pemasukan (+)</option>
                                <option value="pengeluaran" <?= ($data['jenis'] == 'pengeluaran') ? 'selected' : ''; ?>>Pengeluaran (-)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="kategori_id" id="kategori_id" class="form-select rounded-start-3">
                                    <?php
                                    $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                                    while ($k = mysqli_fetch_assoc($kategori)) {
                                        $selected = ($k['id'] == $data['kategori_id']) ? 'selected' : '';
                                        echo "<option value='{$k['id']}' $selected>{$k['nama_kategori']}</option>";
                                    }
                                    ?>
                                </select>
                                <button class="btn btn-outline-primary rounded-end-3" type="button" onclick="tambahKategoriCepat()" title="Tambah Kategori Baru">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jumlah (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" name="jumlah" id="jumlah" class="form-control rounded-end-3" value="<?= $data['jumlah']; ?>" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" class="form-control rounded-3" rows="3"><?= $data['catatan']; ?></textarea>
                    </div>

                    <hr class="text-muted mb-4">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" onclick="validasiEdit()" class="btn btn-warning btn-lg rounded-pill px-5 shadow-sm text-dark fw-bold">
                            <i class="fas fa-edit me-2"></i> Perbarui Data
                        </button>
                    </div>
                    
                    <input type="hidden" name="update" value="1">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validasiEdit() {
        let tanggal = document.getElementById('tanggal').value;
        let jenis = document.getElementById('jenis').value;
        let kategori = document.getElementById('kategori_id').value;
        let jumlah = document.getElementById('jumlah').value;

        if(tanggal === '' || jenis === '' || kategori === '' || jumlah === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap!',
                text: 'Harap isi semua kolom yang bertanda bintang merah (*).'
            });
            return false;
        }

        let angkaRegex = /^[0-9]+$/;
        if(!angkaRegex.test(jumlah)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Salah!',
                text: 'Kolom Jumlah hanya boleh diisi dengan angka.'
            });
            return false;
        }

        document.getElementById('formEdit').submit();
    }
</script>

<?php include '../layouts/footer.php'; ?>