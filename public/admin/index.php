<?php

require_once __DIR__ . '/../../app/models/User.php';
require_once __DIR__ . '/../../app/core/functions.php'; 

$userModel = new User();
$message = '';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'staff')) {
    redirect('dashboard.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    $user = $userModel->getUserByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; 

        ob_start(); 
        redirect('dashboard.php');
        ob_end_flush();
    } else {
        $message = '<div class="alert alert-danger">Username atau password salah.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sewa Motor Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-image: url('../assets/img/login_bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-card-wrapper {
            position: relative;
            z-index: 2;
            padding: 2.5rem;
            border-radius: 1.5rem;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            width: 100%;
            max-width: 420px;
            text-align: left;
        }

        .login-card-wrapper .card-title {
            font-size: 2rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 2rem;
            text-align: center;
        }

        .login-card-wrapper .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .login-card-wrapper .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card-wrapper .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        }

        .login-card-wrapper .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .login-card-wrapper .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 123, 255, 0.3);
        }

        .login-card-wrapper .alert {
            border-radius: 0.75rem;
            font-size: 0.9rem;
            text-align: center;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-logo img {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        .login-logo h4 {
            margin: 0;
            color: #007bff;
            font-weight: 700;
        }
        .login-logo p {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card-wrapper">
        <div class="login-logo">
            <h4>Sewa Motor Online</h4>
            <p>Admin Panel</p>
        </div>
        <h3 class="card-title text-center mb-4">Login</h3>
        <?php echo $message; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2 mt-4">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>