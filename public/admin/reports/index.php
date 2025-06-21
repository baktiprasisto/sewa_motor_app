<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/Order.php';

check_admin_login(['admin']);

$orderModel = new Order();
$orders = [];
$message = '';
$startDate = '';
$endDate = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_report'])) {
    $startDate = htmlspecialchars(trim($_POST['start_date']));
    $endDate = htmlspecialchars(trim($_POST['end_date']));

    if ($startDate && $endDate) {
        $orders = $orderModel->getOrdersByDateRange($startDate, $endDate);
        if (empty($orders)) {
            $message = '<div class="alert alert-info">Tidak ada pesanan dalam rentang tanggal yang dipilih.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Tanggal mulai dan tanggal selesai harus diisi.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
                max-width: none; 
            }
            .card {
                box-shadow: none;
                border: 1px solid #dee2e6; 
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #dee2e6;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .grand-total-row {
                font-weight: bold;
                background-color: #f8f9fa;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
        <div class="container">
            <a class="navbar-brand" href="../dashboard.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../motorcycles/">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="../orders/">Pesanan</a></li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="../profile/">Profil Web</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php">Laporan</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light ms-2" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Laporan Daftar Pesanan</h1>

        <div class="card p-4 mb-4 no-print shadow-sm">
            <h5 class="card-title">Filter Laporan</h5>
            <form action="" method="POST" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Selesai:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="generate_report" class="btn btn-primary w-100">Buat Laporan</button>
                </div>
            </form>
        </div>

        <?php echo $message; ?>

        <?php if (!empty($orders)): ?>
            <div class="text-end mb-3 no-print">
                <button onclick="window.print()" class="btn btn-info"><i class="fas fa-print"></i> Cetak Laporan</button>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">Daftar Pesanan <?php echo htmlspecialchars($startDate); ?> s/d <?php echo htmlspecialchars($endDate); ?></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th> 
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grand_total = 0;
                                $no = 1; 
                                foreach ($orders as $order):
                                    $grand_total += $order['total_price'];
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td> 
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
                                                $display_status_text = '';
                                                switch ($order['status']) {
                                                    case 'request': $display_status_text = 'Menunggu Persetujuan'; break;
                                                    case 'approved': $display_status_text = 'Disetujui'; break;
                                                    case 'rejected': $display_status_text = 'Ditolak'; break;
                                                    case 'completed': $display_status_text = 'Selesai'; break;
                                                    case 'cancelled': $display_status_text = 'Dibatalkan'; break;
                                                    default: $display_status_text = ucfirst($order['status']); break;
                                                }
                                                echo $display_status_text;
                                            ?>
                                        </td>
                                        <td><?php echo date('d-m-Y H:i', strtotime($order['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="9" class="text-end">GRAND TOTAL PENDAPATAN:</th> 
                                    <th colspan="2">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Tidak ada pesanan untuk ditampilkan dalam rentang tanggal yang dipilih.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
