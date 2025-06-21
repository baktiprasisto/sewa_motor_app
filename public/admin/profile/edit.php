<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/WebsiteProfile.php';

check_admin_login(['admin']);

$profileModel = new WebsiteProfile();
$message = '';
$profile = null;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['message'] = '<div class="alert alert-danger">ID profil tidak valid.</div>';
    redirect('index.php');
}

$profile = $profileModel->getProfileById($id);
if (!$profile) {
    $_SESSION['message'] = '<div class="alert alert-danger">Profil tidak ditemukan.</div>';
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_profile'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));

    if ($title && $content) {
        if ($profileModel->updateProfile($id, $title, $content)) {
            $_SESSION['message'] = '<div class="alert alert-success">Profil berhasil diperbarui!</div>';
            redirect('index.php');
        } else {
            $message = '<div class="alert alert-danger">Gagal memperbarui profil.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Judul dan konten profil harus diisi.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Admin</title>
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
        <h1 class="mb-4">Edit Profil: <?php echo htmlspecialchars($profile['title']); ?></h1>
        <?php echo $message; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Profil</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($profile['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten Profil</label>
                <textarea class="form-control" id="content" name="content" rows="7" required><?php echo htmlspecialchars($profile['content']); ?></textarea>
            </div>
            <button type="submit" name="edit_profile" class="btn btn-primary">Update Profil</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>