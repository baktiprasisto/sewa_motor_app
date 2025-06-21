<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/Motorcycle.php';
require_once __DIR__ . '/../../../app/core/Database.php';


check_admin_login(); 

$motorcycleModel = new Motorcycle();
$motorcycles = $motorcycleModel->getAllMotorcycles('id', 'ASC');

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_motorcycle') {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { 
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $motor = $motorcycleModel->getMotorcycleById($id);
            if ($motor && !empty($motor['image_path'])) {
                $absolute_image_path = __DIR__ . '/../../' . $motor['image_path'];
                if (file_exists($absolute_image_path)) {
                    unlink($absolute_image_path);
                }
            }

            if ($motorcycleModel->deleteMotorcycle($id)) {
                $_SESSION['message'] = '<div class="alert alert-success">Motor berhasil dihapus!</div>';
            } else {
                $_SESSION['message'] = '<div class="alert alert-danger">Gagal menghapus motor (Model Error: Database operation failed).</div>';
            }
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">ID motor tidak valid.</div>';
        }
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Anda tidak memiliki hak akses untuk menghapus motor.</div>';
    }
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog Motor - Admin</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="../orders/">Pesanan</a></li>
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
        <h1 class="mb-4">Kelola Katalog Motor</h1>
        <?php echo $message; ?>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="add.php" class="btn btn-success mb-3">Tambah Motor Baru</a>
        <?php endif; ?>

        <?php if (!empty($motorcycles)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama Motor</th>
                            <th>Deskripsi</th>
                            <th>Harga Sewa/Hari</th>
                            <th>Tersedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($motorcycles as $motor): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($motor['id']); ?></td>
                                <td>
                                    <?php if (!empty($motor['image_path']) && file_exists(__DIR__ . '/../../' . $motor['image_path'])): ?>
                                        <img src="../../<?php echo htmlspecialchars($motor['image_path']); ?>" alt="<?php echo htmlspecialchars($motor['name']); ?>" width="80">
                                    <?php else: ?>
                                        Tidak ada gambar
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($motor['name']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars(substr($motor['description'], 0, 70))); ?>...</td>
                                <td>Rp <?php echo number_format($motor['rental_price'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($motor['is_available']): ?>
                                        <span class="badge bg-success">Ya</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $motor['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <form action="" method="POST" class="d-inline delete-form">
                                            <input type="hidden" name="id" value="<?php echo $motor['id']; ?>">
                                            <input type="hidden" name="action" value="delete_motorcycle">
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Belum ada motor yang terdaftar.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../../assets/js/script.js"></script>
</body>
</html>
