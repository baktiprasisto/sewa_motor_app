<?php

require_once __DIR__ . '/../../../app/core/functions.php';
require_once __DIR__ . '/../../../app/models/Motorcycle.php';

check_admin_login();

$motorcycleModel = new Motorcycle();
$message = '';
$motor = null;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['message'] = '<div class="alert alert-danger">ID motor tidak valid.</div>';
    redirect('index.php');
}

$motor = $motorcycleModel->getMotorcycleById($id);
if (!$motor) {
    $_SESSION['message'] = '<div class="alert alert-danger">Motor tidak ditemukan.</div>';
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_motorcycle'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $rental_price_raw = htmlspecialchars(trim($_POST['rental_price']));
    $rental_price_cleaned = str_replace('.', '', $rental_price_raw);
    $rental_price_final = filter_var($rental_price_cleaned, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);

    $is_available = isset($_POST['is_available']) ? 1 : 0;
    $current_image_path = htmlspecialchars(trim($_POST['current_image_path']));

    $image_path = $current_image_path;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_dir = __DIR__ . '/../../assets/img/';
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($file_tmp, $target_file)) {
                if (!empty($current_image_path) && file_exists(__DIR__ . '/../../' . $current_image_path)) {
                    unlink(__DIR__ . '/../../' . $current_image_path);
                }
                $image_path = 'assets/img/' . $file_name;
            } else {
                $message = '<div class="alert alert-danger">Gagal mengupload gambar baru.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Tipe file gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF.</div>';
        }
    }

    if (empty($message)) {
        if ($name && $rental_price_final !== false && $rental_price_final >= 0) {
            if ($motorcycleModel->updateMotorcycle($id, $name, $description, $rental_price_final, $image_path, $is_available)) {
                $_SESSION['message'] = '<div class="alert alert-success">Data motor berhasil diperbarui!</div>';
                redirect('index.php');
            } else {
                $message = '<div class="alert alert-danger">Gagal memperbarui motor.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Nama dan harga sewa harus diisi dengan benar serta format harga valid.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Motor - Admin</title>
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
        <h1 class="mb-4">Edit Motor: <?php echo htmlspecialchars($motor['name']); ?></h1>
        <?php echo $message; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="current_image_path" value="<?php echo htmlspecialchars($motor['image_path']); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Motor</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($motor['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($motor['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="rental_price" class="form-label">Harga Sewa per Hari (Rp)</label>
                <input type="text" class="form-control" id="rental_price" name="rental_price" 
                       value="<?php echo htmlspecialchars($motor['rental_price']); ?>" 
                       required min="0" inputmode="numeric" pattern="[0-9,\.]*">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Motor</label>
                <?php if (!empty($motor['image_path']) && file_exists(__DIR__ . '/../../' . $motor['image_path'])): ?>
                    <div class="mb-2">
                        <img src="../../<?php echo htmlspecialchars($motor['image_path']); ?>" alt="Gambar saat ini" width="150">
                        <small class="text-muted d-block">Gambar saat ini.</small>
                    </div>
                <?php else: ?>
                    <div class="mb-2">
                        <small class="text-muted d-block">Tidak ada gambar saat ini.</small>
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar. Maksimal ukuran file: 2MB. Format: JPG, JPEG, PNG, GIF.</small>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" <?php echo $motor['is_available'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_available">Tersedia untuk disewa</label>
            </div>
            <button type="submit" name="edit_motorcycle" class="btn btn-primary">Update Motor</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>