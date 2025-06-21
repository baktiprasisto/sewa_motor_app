<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/Order.php';

check_admin_login();

$orderModel = new Order();
$order = null;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['message'] = '<div class="alert alert-danger">ID pesanan tidak valid.</div>';
    redirect('index.php');
}

$order = $orderModel->getOrderById($id);
if (!$order) {
    $_SESSION['message'] = '<div class="alert alert-danger">Pesanan tidak ditemukan.</div>';
    redirect('index.php');
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../motorcycles/">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Pesanan</a></li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="../profile/">Profil Web</a></li>
                    <li class="nav-item"><a class="nav-link" href="../reports/">Laporan</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light ms-2" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Detail Pesanan #<?php echo htmlspecialchars($order['id']); ?></h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Informasi Pesanan
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Motor:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($order['motorcycle_name']); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Nama Pelanggan:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($order['customer_email']); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Telepon:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($order['customer_phone']); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Tanggal Mulai Sewa:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($order['rental_start_date']); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Tanggal Selesai Sewa:</strong></div>
                    <div class="col-md-9"><?php echo htmlspecialchars($order['rental_end_date']); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Total Harga:</strong></div>
                    <div class="col-md-9">Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Status:</strong></div>
                    <div class="col-md-9">
                        <?php
                            $status_badge = 'secondary';
                            $display_status_text = '';
                            switch ($order['status']) {
                                case 'request':
                                    $status_badge = 'warning';
                                    $display_status_text = 'Menunggu Persetujuan';
                                    break;
                                case 'approved':
                                    $status_badge = 'success';
                                    $display_status_text = 'Disetujui';
                                    break;
                                case 'rejected':
                                    $status_badge = 'danger';
                                    $display_status_text = 'Ditolak';
                                    break;
                                case 'completed':
                                    $status_badge = 'info';
                                    $display_status_text = 'Selesai';
                                    break;
                                case 'cancelled':
                                    $status_badge = 'dark';
                                    $display_status_text = 'Dibatalkan';
                                    break;
                                default:
                                    $display_status_text = ucfirst($order['status']);
                                    break;
                            }
                        ?>
                        <span class="badge bg-<?php echo $status_badge; ?>"><?php echo $display_status_text; ?></span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Catatan:</strong></div>
                    <div class="col-md-9"><?php echo nl2br(htmlspecialchars($order['notes'])); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Tanggal Pesan:</strong></div>
                    <div class="col-md-9"><?php echo date('d-m-Y H:i', strtotime($order['created_at'])); ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Terakhir Diperbarui:</strong></div>
                    <div class="col-md-9"><?php echo date('d-m-Y H:i', strtotime($order['updated_at'])); ?></div>
                </div>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> </body>
</html>