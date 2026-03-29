<?php
include '../config/koneksi.php';
include '../layouts/header.php';

// Ambil data lama
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_data = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query_data);
    
    if (!$data) {
        echo "<script>window.location.href = 'kategori.php';</script>";
        exit;
    }
}

// Proses update
if (isset($_POST['update'])) {
    $id_kategori = $_POST['id'];
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $query_update = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = '$id_kategori'";
    
    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>window.location.href = 'kategori.php?pesan=edit_sukses';</script>";
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
                <h3 class="fw-bold text-dark mb-0">Edit Kategori</h3>
            </div>
            <a href="kategori.php" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body p-5">
                <form action="" method="POST" id="formEditKategori">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control rounded-3" value="<?= $data['nama_kategori']; ?>">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" onclick="validasiKategori()" class="btn btn-warning btn-lg rounded-pill px-5 shadow-sm text-dark fw-bold">
                            <i class="fas fa-edit me-2"></i> Perbarui
                        </button>
                    </div>
                    
                    <input type="hidden" name="update" value="1">
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
        document.getElementById('formEditKategori').submit();
    }
</script>

<?php include '../layouts/footer.php'; ?>