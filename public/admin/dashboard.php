<?php

require_once __DIR__ . '/../../app/core/functions.php';

check_admin_login(); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sewa Motor Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="motorcycles/">Kelola Katalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders/">Kelola Pesanan</a>
                    </li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile/">Kelola Profil Website</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports/">Laporan</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2" href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p class="lead">Anda berada di halaman **Dashboard Admin Sewa Motor Online**.</p>
        <?php if (isset($_SESSION['message'])): ?>
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Katalog Motor</h5>
                        <p class="card-text">Tambah, edit, dan hapus data motor yang tersedia untuk disewa.</p>
                        <a href="motorcycles/" class="btn btn-primary">Lihat Katalog</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Pesanan</h5>
                        <p class="card-text">Lihat dan ubah status pesanan yang masuk dari pelanggan.</p>
                        <a href="orders/" class="btn btn-primary">Lihat Pesanan</a>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kelola Profil Website</h5>
                        <p class="card-text">Ubah informasi statis seperti "Tentang Kami" atau "Kontak".</p>
                        <a href="profile/" class="btn btn-primary">Edit Profil</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Pesanan</h5>
                        <p class="card-text">Buat laporan ringkasan daftar pesanan berdasarkan periode.</p>
                        <a href="reports/" class="btn btn-primary">Buat Laporan</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>