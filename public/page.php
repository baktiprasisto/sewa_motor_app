<?php

require_once __DIR__ . '/../app/models/WebsiteProfile.php';

$profileModel = new WebsiteProfile();
$profileData = null; 

$allProfiles = $profileModel->getAllProfiles();

$requested_title = isset($_GET['title']) ? htmlspecialchars(trim($_GET['title'])) : '';

if (!empty($requested_title)) {
    $profileData = $profileModel->getProfileByTitle($requested_title);
}

if (!$profileData) {
    $page_title = 'Halaman Tidak Ditemukan';
    $page_content = 'Maaf, konten yang Anda cari tidak tersedia atau belum diisi oleh administrator.';
} else {
    $page_title = $profileData['title'];
    $page_content = $profileData['content'];
}

// Untuk menentukan active link di navbar
$current_page = basename($_SERVER['PHP_SELF']); // Mengambil nama file saat ini (misal: "page.php")
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Sewa Motor Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
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
                        <!-- Link Katalog: Aktif jika halaman saat ini adalah index.php dan tidak ada parameter title -->
                        <a class="nav-link <?php echo ($current_page == 'index.php' && empty($requested_title)) ? 'active' : ''; ?>" href="index.php">Katalog</a>
                    </li>
                    <?php
                    if (!empty($allProfiles)) {
                        foreach ($allProfiles as $profile) {
                            $profile_url_title = urlencode($profile['title']);
                            // Link Profil: Aktif jika requested_title cocok dengan judul profil ini
                            $is_active = ($current_page == 'page.php' && $requested_title == $profile['title']) ? 'active' : '';
                            
                            echo '<li class="nav-item">';
                            echo '<a class="nav-link ' . $is_active . '" href="page.php?title=' . htmlspecialchars($profile_url_title) . '">' . htmlspecialchars($profile['title']) . '</a>';
                            echo '</li>';
                        }
                    }
                    ?>
                    <li class="nav-item">
                        <!-- Link Cek Status Order: Aktif jika halaman saat ini adalah check_order.php -->
                        <a class="nav-link <?php echo ($current_page == 'check_order.php') ? 'active' : ''; ?>" href="check_order.php">Cek Status Order</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4"><?php echo htmlspecialchars($page_title); ?></h1>
        <div class="card p-4 shadow-sm">
            <?php
            echo nl2br(htmlspecialchars($page_content));
            ?>
        </div>
    </div>
    <footer class="bg-light text-center text-lg-start mt-5 py-3">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Sewa Motor Online. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Tambahkan script.js jika ada custom JS yang dipakai di halaman page.php -->
    <script src="assets/js/script.js"></script> 
</body>
</html>
