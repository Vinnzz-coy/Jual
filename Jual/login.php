<?php
session_start();

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $register_error = "Password tidak cocok!";
    } else {
        $check_query = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $register_error = "Username sudah digunakan!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
            $stmt = mysqli_prepare($koneksi, $insert_query);
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
            
            if (mysqli_stmt_execute($stmt)) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $register_error = "Gagal melakukan registrasi: " . mysqli_error($koneksi);
            }
        }
    }
}

if (isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Perlengkapan Sekolah</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-tabs">
            <button class="tab-btn active" id="loginTab">Login</button>
            <button class="tab-btn" id="registerTab">Daftar</button>
        </div>

        <div class="auth-content">
            <div class="auth-form active" id="loginForm">
                <div class="auth-header">
                    <i class="fas fa-school"></i>
                    <h1>Masuk ke Sistem</h1>
                    <p>Silakan masuk untuk mengelola inventaris</p>
                </div>

                <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <input type="hidden" name="login" value="1">
                    <div class="input-group">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                    </div>

                    <div class="input-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn-auth btn-login">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>
            </div>

            <div class="auth-form" id="registerForm">
                <div class="auth-header">
                    <i class="fas fa-user-plus"></i>
                    <h1>Buat Akun Baru</h1>
                    <p>Daftar untuk mengakses sistem</p>
                </div>

                <?php if (isset($register_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $register_error; ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <input type="hidden" name="register" value="1">
                    <div class="input-group">
                        <label for="reg_username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" id="reg_username" name="username" placeholder="Buat username" required>
                    </div>

                    <div class="input-group">
                        <label for="reg_password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="reg_password" name="password" placeholder="Buat password" required>
                    </div>

                    <div class="input-group">
                        <label for="reg_confirm_password"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                        <input type="password" id="reg_confirm_password" name="confirm_password"
                            placeholder="Ulangi password" required>
                    </div>

                    <button type="submit" class="btn-auth btn-register">
                        <i class="fas fa-user-plus"></i> Daftar
                    </button>
                </form>
            </div>
        </div>

        <div class="auth-footer">
            <p>&copy; <?php echo date('Y'); ?> Toko Perlengkapan Sekolah</p>
        </div>
    </div>

    <script>
    document.getElementById('loginTab').addEventListener('click', function() {
        document.getElementById('loginTab').classList.add('active');
        document.getElementById('registerTab').classList.remove('active');
        document.getElementById('loginForm').classList.add('active');
        document.getElementById('registerForm').classList.remove('active');
    });

    document.getElementById('registerTab').addEventListener('click', function() {
        document.getElementById('registerTab').classList.add('active');
        document.getElementById('loginTab').classList.remove('active');
        document.getElementById('registerForm').classList.add('active');
        document.getElementById('loginForm').classList.remove('active');
    });
    </script>
</body>

</html>