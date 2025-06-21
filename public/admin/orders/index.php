<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/Order.php';
require_once __DIR__ . '/../../../app/models/Motorcycle.php';

check_admin_login();

$orderModel = new Order();
$motorcycleModel = new Motorcycle();

$orders = $orderModel->getAllOrders();

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
    $status = htmlspecialchars(trim($_POST['status']));

    if ($order_id && in_array($status, ['request', 'approved', 'rejected', 'completed', 'cancelled'])) {
        if ($orderModel->updateOrderStatus($order_id, $status)) {
            $_SESSION['message'] = '<div class="alert alert-success">Status pesanan berhasil diperbarui!</div>';

            $order_info = $orderModel->getOrderById($order_id);
            if ($order_info) {
                $motor_id_affected = $order_info['motorcycle_id'];
                $motor_details = $motorcycleModel->getMotorcycleById($motor_id_affected);

                if ($motor_details) {
                    if ($status === 'approved') {
                        $motorcycleModel->updateMotorcycle(
                            $motor_id_affected,
                            $motor_details['name'],
                            $motor_details['description'],
                            $motor_details['rental_price'],
                            $motor_details['image_path'],
                            FALSE 
                        );
                    } elseif ($status === 'completed' || $status === 'rejected' || $status === 'cancelled') {
                        $motorcycleModel->updateMotorcycle(
                            $motor_id_affected,
                            $motor_details['name'],
                            $motor_details['description'],
                            $motor_details['rental_price'],
                            $motor_details['image_path'],
                            TRUE 
                        );
                    }
                }
            }
            
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">Gagal memperbarui status pesanan.</div>';
        }
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Data tidak valid.</div>';
    }
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - Admin</title>
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
        <h1 class="mb-4">Kelola Pesanan</h1>
        <?php echo $message; ?>

        <?php if (!empty($orders)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Motor</th>
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Tgl Mulai</th>
                            <th>Tgl Selesai</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tgl Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['motorcycle_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                <td><?php echo htmlspecialchars($order['rental_start_date']); ?></td>
                                <td><?php echo htmlspecialchars($order['rental_end_date']); ?></td>
                                <td>Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                                <td>
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
                                </td>
                                <td><?php echo date('d-m-Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <select name="status" class="form-select form-select-sm d-inline-block w-auto me-1">
                                            <option value="request" <?php echo ($order['status'] == 'request') ? 'selected' : ''; ?>>Menunggu Persetujuan</option>
                                            <option value="approved" <?php echo ($order['status'] == 'approved') ? 'selected' : ''; ?>>Disetujui</option>
                                            <option value="rejected" <?php echo ($order['status'] == 'rejected') ? 'selected' : ''; ?>>Ditolak</option>
                                            <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Selesai</option>
                                            <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Dibatalkan</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-sm btn-primary">Ubah</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Belum ada pesanan yang masuk.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> </body>
</html>