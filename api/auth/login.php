<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-primary d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow-lg border-0 rounded-4" style="width: 25rem;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fas fa-wallet fa-3x text-primary mb-3"></i>
                <h4 class="fw-bold">Login KeuanganKu</h4>
                <p class="text-muted">Silakan masuk untuk melanjutkan</p>
            </div>

            <form action="proses_login.php" method="POST" id="formLogin">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Masuk</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php 
    // Menangkap pesan dari proses login atau logout
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal") {
            echo "<script>Swal.fire('Login Gagal!', 'Username atau password salah.', 'error');</script>";
        } else if ($_GET['pesan'] == "logout") {
            echo "<script>Swal.fire('Berhasil Logout!', 'Kamu telah keluar dari sistem.', 'success');</script>";
        } else if ($_GET['pesan'] == "belum_login") {
            echo "<script>Swal.fire('Akses Ditolak!', 'Silakan login terlebih dahulu.', 'warning');</script>";
        }
    } 
    ?>
</body>
</html>