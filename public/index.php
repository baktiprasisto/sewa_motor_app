<?php
// public/index.php

require_once __DIR__ . '/../app/models/Motorcycle.php';
require_once __DIR__ . '/../app/models/Order.php';
require_once __DIR__ . '/../app/models/WebsiteProfile.php'; 

$motorcycleModel = new Motorcycle();
$orderModel = new Order();
$profileModel = new WebsiteProfile(); 

$allProfiles = $profileModel->getAllProfiles();

// Ambil kata kunci pencarian dari URL jika ada
$search_query = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : null;

// Mengurutkan motor berdasarkan rental_price dari yang terendah ke tertinggi, DAN menerapkan pencarian
$motorcycles = $motorcycleModel->getAllMotorcycles('rental_price', 'ASC', $search_query);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    $motorcycle_id = filter_input(INPUT_POST, 'motorcycle_id', FILTER_VALIDATE_INT);
    $customer_name = htmlspecialchars(trim($_POST['customer_name']));
    $customer_email = filter_input(INPUT_POST, 'customer_email', FILTER_VALIDATE_EMAIL);
    $customer_phone = htmlspecialchars(trim($_POST['customer_phone'])); 
    $rental_start_date = htmlspecialchars(trim($_POST['rental_start_date']));
    $rental_end_date = htmlspecialchars(trim($_POST['rental_end_date']));

    if ($motorcycle_id && $customer_name && $customer_email && $customer_phone && $rental_start_date && $rental_end_date) {
        $motor = $motorcycleModel->getMotorcycleById($motorcycle_id);
        if ($motor && $motor['is_available']) {
            $start_date = new DateTime($rental_start_date);
            $end_date = new DateTime($rental_end_date);

            if ($start_date <= $end_date) {
                $interval = $start_date->diff($end_date);
                $days = $interval->days + 1;
                $total_price = $days * $motor['rental_price'];

                if ($orderModel->addOrder($motorcycle_id, $customer_name, $customer_email, $customer_phone, $rental_start_date, $rental_end_date, $total_price)) {
                    $message = '<div class="alert alert-success">Pesanan Anda berhasil dikirim! Kami akan segera menghubungi Anda melalui Whatsapp.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Gagal membuat pesanan. Silakan coba lagi.</div>';
                }
            } else {
                $message = '<div class="alert alert-danger">Tanggal selesai sewa harus setelah atau sama dengan tanggal mulai sewa.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Motor tidak ditemukan atau tidak tersedia.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Mohon lengkapi semua field dengan benar.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Motor Online - Katalog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sewa Motor Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && empty($search_query)) ? 'active' : ''; ?>" aria-current="page" href="index.php">Katalog</a>
                    </li>
                    <?php
                    if (!empty($allProfiles)) {
                        foreach ($allProfiles as $profile) {
                            $profile_url_title = urlencode($profile['title']);
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="page.php?title=' . htmlspecialchars($profile_url_title) . '">' . htmlspecialchars($profile['title']) . '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                    <!-- Tambahkan Link untuk Cek Status Order (nanti dibuat file-nya) -->
                    <li class="nav-item">
                        <a class="nav-link" href="check_order.php">Cek Status Order</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Katalog Motor yang Tersedia</h1>
        <?php echo $message; ?>

        <!-- Form Pencarian Motor -->
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <form action="index.php" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari motor..." value="<?php echo htmlspecialchars($search_query ?: ''); ?>">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <?php if ($search_query): // Tampilkan tombol reset jika ada pencarian ?>
                    <a href="index.php" class="btn btn-secondary ms-2">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($motorcycles)): ?>
                <?php foreach ($motorcycles as $motor): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo htmlspecialchars($motor['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($motor['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($motor['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo nl2br(htmlspecialchars($motor['description'])); ?></p>
                                <p class="card-text"><strong>Harga Sewa: Rp <?php echo number_format($motor['rental_price'], 0, ',', '.'); ?>/hari</strong></p>
                                <p class="card-text">Status:
                                    <?php if ($motor['is_available']): ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak Tersedia</span>
                                    <?php endif; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <?php if ($motor['is_available']): ?>
                                        <button type="button" class="btn btn-primary me-2 flex-grow-1" data-bs-toggle="modal" data-bs-target="#orderModal_<?php echo $motor['id']; ?>">
                                            Pesan Sekarang
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-secondary me-2 flex-grow-1" disabled>Tidak Tersedia</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="orderModal_<?php echo $motor['id']; ?>" tabindex="-1" aria-labelledby="orderModalLabel_<?php echo $motor['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="orderModalLabel_<?php echo $motor['id']; ?>">Pesan <?php echo htmlspecialchars($motor['name']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="">
                                    <div class="modal-body">
                                        <input type="hidden" name="motorcycle_id" value="<?php echo $motor['id']; ?>">
                                        <div class="mb-3">
                                            <label for="customer_name_<?php echo $motor['id']; ?>" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="customer_name_<?php echo $motor['id']; ?>" name="customer_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customer_email_<?php echo $motor['id']; ?>" class="form-label">Email (Identitas)</label>
                                            <input type="email" class="form-control" id="customer_email_<?php echo $motor['id']; ?>" name="customer_email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customer_phone_<?php echo $motor['id']; ?>" class="form-label">Nomor Telepon (Wajib)</label>
                                            <input type="tel" class="form-control" id="customer_phone_<?php echo $motor['id']; ?>" name="customer_phone" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rental_start_date_<?php echo $motor['id']; ?>" class="form-label">Tanggal Mulai Sewa</label>
                                            <input type="date" class="form-control" id="rental_start_date_<?php echo $motor['id']; ?>" name="rental_start_date" required min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="rental_end_date_<?php echo $motor['id']; ?>" class="form-label">Tanggal Selesai Sewa</label>
                                            <input type="date" class="form-control" id="rental_end_date_<?php echo $motor['id']; ?>" name="rental_end_date" required min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="submit_order" class="btn btn-primary">Kirim Pesanan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="lead">Maaf, belum ada motor yang tersedia untuk disewa saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-light text-center text-lg-start mt-5 py-3">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Sewa Motor Online. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>