<?php
session_start();
include 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['token'], $_POST['new_password'], $_POST['confirm_password'])) {
        $_SESSION['notif'] = "Data tidak lengkap!";
        header("Location: reset_password.php?token=" . $_POST['token']);
        exit();
    }

    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi konfirmasi password
    if ($new_password !== $confirm_password) {
        $_SESSION['notif'] = "Password baru dan konfirmasi tidak cocok!";
        header("Location: reset_password.php?token=" . $token);
        exit();
    }

    // Hash password baru
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Cari user berdasarkan token
    $sql = "(SELECT id, 'users' AS table_name FROM users WHERE reset_token = ?) 
            UNION 
            (SELECT id, 'admin' AS table_name FROM admin WHERE reset_token = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $token, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['notif'] = "Token tidak valid atau sudah digunakan.";
        header("Location: reset_password.php?token=" . $token);
        exit();
    }

    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $table_name = $user['table_name']; // Menentukan tabel yang digunakan (users atau admin)

    // Update password dan hapus token
    $update_sql = "UPDATE $table_name SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        $_SESSION['notif'] = "Password berhasil diubah! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['notif'] = "Gagal mengubah password. Coba lagi.";
        header("Location: reset_password.php?token=" . $token);
        exit();
    }
}
?>
