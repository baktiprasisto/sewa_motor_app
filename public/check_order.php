<?php
// public/check_order.php

require_once __DIR__ . '/../app/models/Order.php';
require_once __DIR__ . '/../app/models/WebsiteProfile.php'; // Untuk navigasi dinamis

$orderModel = new Order();
$profileModel = new WebsiteProfile();
$allProfiles = $profileModel->getAllProfiles(); // Untuk navbar dinamis

$search_email = '';
$search_phone = '';
$customer_orders = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_status'])) {
    $search_email = htmlspecialchars(trim($_POST['email']));
    $search_phone = htmlspecialchars(trim($_POST['phone']));

    if (empty($search_email) && empty($search_phone)) {
        $message = '<div class="alert alert-danger">Mohon masukkan Email atau Nomor Telepon Anda.</div>';
    } else {
        $customer_orders = $orderModel->getOrdersByCustomerContact($search_email, $search_phone);
        
        if (empty($customer_orders)) {
            $message = '<div class="alert alert-info">Tidak ada pesanan ditemukan dengan informasi tersebut.</div>';
        } else {
            $message = '<div class="alert alert-success">Pesanan Anda berhasil ditemukan!</div>';
        }
    }
}

// Untuk menentukan active link di navbar
$requested_title = ''; // Di halaman ini tidak ada parameter title untuk active link profile
$current_page = basename($_SERVER['PHP_SELF']); // Untuk menandai active link di navbar
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pesanan - Sewa Motor Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .table-responsive-custom {
            overflow-x: auto;
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
                        <a class="nav-link" href="index.php">Katalog</a>
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
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_page == 'check_order.php') ? 'active' : ''; ?>" href="check_order.php">Cek Status Order</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Cek Status Pesanan Anda</h1>
        <?php echo $message; ?>

        <div class="card p-4 shadow-sm mb-4">
            <h5 class="card-title">Cari Pesanan Anda</h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Anda (Opsional)</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($search_email); ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon Anda (Opsional)</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($search_phone); ?>">
                    <small class="form-text text-muted">Masukkan salah satu atau keduanya untuk mencari pesanan Anda.</small>
                </div>
                <button type="submit" name="check_status" class="btn btn-primary">Cek Status</button>
            </form>
        </div>

        <?php if (!empty($customer_orders)): ?>
            <h3 class="mb-3">Daftar Pesanan Ditemukan:</h3>
            <div class="table-responsive table-responsive-custom">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Motor</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tgl Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer_orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['motorcycle_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['rental_start_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['rental_end_date']); ?></td>
                                <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php
                                        $status_badge = 'secondary';
                                        $display_status_text = '';
                                        switch ($order['status']) {
                                            case 'request': $status_badge = 'warning'; $display_status_text = 'Menunggu Persetujuan'; break;
                                            case 'approved': $status_badge = 'success'; $display_status_text = 'Disetujui'; break;
                                            case 'rejected': $status_badge = 'danger'; $display_status_text = 'Ditolak'; break;
                                            case 'completed': $status_badge = 'info'; $display_status_text = 'Selesai'; break;
                                            case 'cancelled': $status_badge = 'dark'; $display_status_text = 'Dibatalkan'; break;
                                            default: $display_status_text = ucfirst($order['status']); break;
                                        }
                                    ?>
                                    <span class="badge bg-<?php echo $status_badge; ?>"><?php echo $display_status_text; ?></span>
                                </td>
                                <td><?php echo date('d-m-Y H:i', strtotime($order['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
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