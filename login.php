<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['role'];

    $sql = "SELECT * FROM users WHERE username = ? AND role_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $username, $role_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Simpan data ke sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['username'] = $user['username']; // Menyimpan username ke sesi

        // Redirect berdasarkan peran pengguna
        if ($user['role_id'] == 1) {
            header("Location: admin_dashboard.php");
        } elseif ($user['role_id'] == 2) {
            header("Location: guru_dashboard.php");
        } else {
            header("Location: siswa_dashboard.php");
        }
        exit();
    } else {
        $error = "Username or Password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <h2>Masuk Akun</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" name="username" placeholder="Nama User" required>
            <input type="password" name="password" placeholder="Kata Sandi" required>
            <select name="role" required>
                <option value="1">Admin</option>
                <option value="2">Guru</option>
                <option value="3">Siswa</option>
            </select>
            <button type="submit">Masuk</button>
        </form>
        <div class="message">
            Belum punya akun? <a href="register.php">Daftar sekarang</a>
        </div>
    </div>
</body>
</html>
