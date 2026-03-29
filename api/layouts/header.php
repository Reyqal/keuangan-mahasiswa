<?php
// Mulai session di header agar semua halaman yang include header ini otomatis mengecek session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login, jika belum arahkan ke login.php
// (Kecuali jika saat ini sedang berada di halaman login)
$current_page = basename($_SERVER['PHP_SELF']);
// MENJADI SEPERTI INI (Tambahkan BASE_URL di location-nya):
if (!isset($_SESSION['user_id']) && $current_page != 'login.php' && $current_page != 'proses_login.php') {
    header("Location: " . BASE_URL . "auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Keuangan Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<?php if (isset($_SESSION['user_id'])) : ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-wallet"></i> KeuanganKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>transaksi/index.php">Data Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>kategori/index.php">Kelola Kategori</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link text-white fw-bold">
                        <i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['username']); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#" onclick="konfirmasiLogout()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
<?php endif; ?>