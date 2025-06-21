<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/WebsiteProfile.php';
require_once __DIR__ . '/../../../app/core/Database.php';


check_admin_login(['admin']);

$profileModel = new WebsiteProfile();
$profiles = $profileModel->getAllProfiles();

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Logika untuk menghapus profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_profile') {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            if ($profileModel->deleteProfile($id)) {
                $_SESSION['message'] = '<div class="alert alert-success">Profil berhasil dihapus!</div>';
            } else {
                $_SESSION['message'] = '<div class="alert alert-danger">Gagal menghapus profil (Model Error: Database operation failed).</div>';
            }
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger">ID profil tidak valid.</div>';
        }
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger">Anda tidak memiliki hak akses untuk menghapus profil.</div>';
    }
    redirect('index.php');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Profil Website - Admin</title>
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
                    <li class="nav-item"><a class="nav-link" href="../orders/">Pesanan</a></li>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php">Profil Web</a></li>
                    <li class="nav-item"><a class="nav-link" href="../reports/">Laporan</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link btn btn-outline-light ms-2" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Kelola Profil Website</h1>
        <?php echo $message; ?>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="add.php" class="btn btn-success mb-3">Tambah Profil Baru</a>
        <?php endif; ?>

        <?php if (!empty($profiles)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Konten (Preview)</th>
                            <th>Terakhir Diperbarui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($profiles as $profile): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($profile['id']); ?></td>
                                <td><?php echo htmlspecialchars($profile['title']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars(substr($profile['content'], 0, 100))); ?>...</td>
                                <td><?php echo date('d-m-Y H:i', strtotime($profile['last_updated_at'])); ?></td>
                                <td>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <a href="edit.php?id=<?php echo $profile['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="" method="POST" class="d-inline delete-form">
                                            <input type="hidden" name="id" value="<?php echo $profile['id']; ?>">
                                            <input type="hidden" name="action" value="delete_profile">
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
            <div class="alert alert-info">Belum ada profil website yang terdaftar.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../../assets/js/script.js"></script>
</body>
</html>
