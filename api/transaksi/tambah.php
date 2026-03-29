<?php
include '../config/koneksi.php';
include '../layouts/header.php';

// Menangkap proses simpan data ketika form disubmit
if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = $_POST['tanggal'];
    $kategori_id = $_POST['kategori_id'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);

    // Proses insert ke database
    $query = "INSERT INTO transaksi (user_id, kategori_id, tanggal, jenis, jumlah, catatan) 
              VALUES ('$user_id', '$kategori_id', '$tanggal', '$jenis', '$jumlah', '$catatan')";
    
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, lempar kembali ke halaman transaksi dengan pesan sukses
        echo "<script>window.location.href = 'index.php?pesan=tambah_sukses';</script>";
    } else {
        // Jika gagal insert (misal server down)
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
            });
        </script>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">Tambah Transaksi Baru</h3>
                <p class="text-muted mb-0">Catat pemasukan atau pengeluaranmu di sini.</p>
            </div>
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body p-5">
                <form action="" method="POST" id="formTambah">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control rounded-3" value="<?= date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Transaksi <span class="text-danger">*</span></label>
                            <select name="jenis" id="jenis" class="form-select rounded-3">
                                <option value="" selected disabled>-- Pilih Jenis --</option>
                                <option value="pemasukan">Pemasukan (+)</option>
                                <option value="pengeluaran">Pengeluaran (-)</option>
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
                                <input type="number" name="jumlah" id="jumlah" class="form-control rounded-end-3" placeholder="Contoh: 50000" min="0">
                            </div>
                            <small class="text-muted">Hanya masukkan angka, tanpa titik/koma.</small>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-semibold">Catatan (Opsional)</label>
                        <textarea name="catatan" id="catatan" class="form-control rounded-3" rows="3" placeholder="Contoh: Beli nasi goreng depan kampus"></textarea>
                    </div>

                    <hr class="text-muted mb-4">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" onclick="validasiSebelumSubmit()" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan Data
                        </button>
                    </div>
                    
                    <input type="hidden" name="simpan" value="1">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validasiSebelumSubmit() {
        // Ambil nilai dari setiap input
        let tanggal = document.getElementById('tanggal').value;
        let jenis = document.getElementById('jenis').value;
        let kategori = document.getElementById('kategori_id').value;
        let jumlah = document.getElementById('jumlah').value;

        // 1. Validasi: Cek apakah ada yang kosong
        if(tanggal === '' || jenis === '' || kategori === '' || jumlah === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap!',
                text: 'Harap isi semua kolom yang bertanda bintang merah (*).'
            });
            return false;
        }

        // 2. Validasi: Cek apakah field jumlah benar-benar hanya angka
        // (Walaupun type="number" sudah membatasi, ini extra proteksi untuk syarat tugas)
        let angkaRegex = /^[0-9]+$/;
        if(!angkaRegex.test(jumlah)) {
            Swal.fire({
                icon: 'error',
                title: 'Format Salah!',
                text: 'Kolom Jumlah hanya boleh diisi dengan angka (tidak boleh negatif atau huruf).'
            });
            return false;
        }

        // Jika semua validasi lulus, submit formnya secara manual
        document.getElementById('formTambah').submit();
    }
</script>

<?php include '../layouts/footer.php'; ?>