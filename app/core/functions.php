<?php

function redirect($url) {
    header("Location: " . $url);
    exit();
}


function check_admin_login($required_role = ['admin', 'staff']) {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    if (!isset($_SESSION['user_id'])) {

        $_SESSION['message'] = '<div class="alert alert-danger">Anda harus login untuk mengakses halaman ini.</div>';
        redirect('index.php'); 
    }

    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $required_role)) {

        $_SESSION['message'] = '<div class="alert alert-danger">Anda tidak memiliki hak akses untuk halaman ini.</div>';
        redirect('dashboard.php');
    }

}
?>