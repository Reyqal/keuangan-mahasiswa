<?php
include '../config/koneksi.php';
include '../layouts/header.php';

if (isset($_POST['simpan'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>window.location.href = 'index.php?pesan=tambah_sukses';</script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
            });
        </script>";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">Tambah Kategori</h3>
            </div>
            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body p-5">
                <form action="" method="POST" id="formTambahKategori">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control rounded-3" placeholder="Contoh: Belanja Bulanan">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" onclick="validasiKategori()" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                    
                    <input type="hidden" name="simpan" value="1">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validasiKategori() {
        let nama = document.getElementById('nama_kategori').value;
        if(nama.trim() === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Data Kosong!',
                text: 'Nama kategori tidak boleh kosong.'
            });
            return false;
        }
        document.getElementById('formTambahKategori').submit();
    }
</script>

<?php include '../layouts/footer.php'; ?>