<?php
session_start();
include 'includes/db.php';

$error = ''; // Inisialisasi variabel error

// Menampilkan notifikasi jika ada

$notif = isset($_SESSION['notif']) ? $_SESSION['notif'] : '';
unset($_SESSION['notif']); // Hapus notifikasi setelah ditampilkan


// Menampilkan notifikasi registrasi berhasil jika ada
if (isset($_SESSION['registration_success'])) {
    echo "<script>alert('" . $_SESSION['registration_success'] . "');</script>";
    unset($_SESSION['registration_success']); // Hapus notifikasi setelah ditampilkan
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek login di tabel users (siswa)
    $sql_users = "SELECT * FROM users WHERE email = ?";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("s", $email);
    $stmt_users->execute();
    $result_users = $stmt_users->get_result();

    if ($result_users->num_rows > 0) {
        $user = $result_users->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['username'] = $user['fullname']; // Menyimpan nama pengguna
            header("Location: siswa_dashboard.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        // Jika tidak ditemukan di tabel users, cek di tabel admin
        $sql_admin = "SELECT * FROM admin WHERE email = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("s", $email);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        if ($result_admin->num_rows > 0) {
            $admin = $result_admin->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['user_id'] = $admin['id']; // Gunakan user_id agar sesuai dengan admin_dashboard.php
                $_SESSION['fullname'] = $admin['fullname'];
                $_SESSION['role_id'] = 2; // Role admin harus 2
                $_SESSION['username'] = $admin['fullname']; // Menyimpan nama admin
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Email tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px; /* Ruang untuk ikon */
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <!-- Menampilkan notifikasi jika ada -->
        <?php if (!empty($notif)): ?>
            <div class="notif"><?php echo htmlspecialchars($notif); ?></div>
        <?php endif; ?>

        <!-- Menampilkan error login jika ada -->
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Kata Sandi" required>
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>
            
            <br>
            <div class="message">
                Lupa kata sandi? <a href="forgot_password.php">Klik disini</a><br>
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="message">
            Belum punya akun? <a href="register.php">Daftar disini</a>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            let input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
