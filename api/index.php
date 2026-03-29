<?php
// Ba Konek
include 'config/koneksi.php';
include 'layouts/header.php'; 

$user_id = $_SESSION['user_id'];

// Bahitung Total Pemasukan
$query_masuk = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pemasukan FROM transaksi WHERE user_id = '$user_id' AND jenis = 'pemasukan'");
$data_masuk = mysqli_fetch_assoc($query_masuk);
$total_pemasukan = $data_masuk['total_pemasukan'] ? $data_masuk['total_pemasukan'] : 0;

// Bahitung Total Pengeluaran
$query_keluar = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total_pengeluaran FROM transaksi WHERE user_id = '$user_id' AND jenis = 'pengeluaran'");
$data_keluar = mysqli_fetch_assoc($query_keluar);
$total_pengeluaran = $data_keluar['total_pengeluaran'] ? $data_keluar['total_pengeluaran'] : 0;

// Bahitung Saldo Akhir
$saldo_akhir = $total_pemasukan - $total_pengeluaran;
?>

<div class="row mb-4 mt-2">
    <div class="col-12">
        <h2 class="fw-bold">Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p class="text-muted">Ini adalah ringkasan keuangan pribadimu bulan ini.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm border-0 rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Total Pemasukan</h5>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="fas fa-arrow-down fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">Rp <?= number_format($total_pemasukan, 0, ',', '.'); ?></h3>
            </div>
            <i class="fas fa-chart-line position-absolute text-white opacity-25" style="bottom: -15px; right: -15px; font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white shadow-sm border-0 rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Total Pengeluaran</h5>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="fas fa-arrow-up fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?></h3>
            </div>
            <i class="fas fa-chart-pie position-absolute text-white opacity-25" style="bottom: -15px; right: -15px; font-size: 6rem;"></i>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm border-0 rounded-4 h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Saldo Saat Ini</h5>
                    <div class="bg-white bg-opacity-25 rounded-circle p-2">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0">Rp <?= number_format($saldo_akhir, 0, ',', '.'); ?></h3>
            </div>
            <i class="fas fa-coins position-absolute text-white opacity-25" style="bottom: -15px; right: -15px; font-size: 6rem;"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-center">
        <a href="transaksi/tambah.php" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm me-2">
            <i class="fas fa-plus-circle me-2"></i>Catat Transaksi Baru
        </a>
        <a href="transaksi/index.php" class="btn btn-outline-secondary btn-lg rounded-pill px-4 bg-white shadow-sm">
            <i class="fas fa-list me-2"></i>Lihat Semua Data
        </a>
    </div>
</div>

<?php 
// NAH, FOOTER-NYA HARUS ADA DI PALING BAWAH SINI YA!
include 'layouts/footer.php'; 
?>