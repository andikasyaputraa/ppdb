<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Query untuk mencari pengguna di kedua tabel
    $sql = "(SELECT id, email FROM users WHERE email = ?) 
            UNION 
            (SELECT id, email FROM admin WHERE email = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32)); // Selalu generate token baru
        $expiry_time = date("Y-m-d H:i:s", strtotime("+1 day"));

        // Cek di tabel mana email ditemukan
        $sql_check_user = "SELECT email FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check_user);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $update = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        } else {
            $update = "UPDATE admin SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";
        }

        $stmt_update = $conn->prepare($update);
        $stmt_update->bind_param("sss", $token, $expiry_time, $email);

        if ($stmt_update->execute()) {
            // Konfigurasi SMTP PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ppdbsmkhijaumuda@gmail.com';
                $mail->Password = 'ftnn tohn cbgi ejgh';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Pengaturan email
                $mail->setFrom('ppdbsmkhijaumuda@gmail.com', 'Panitia SMK HIJAU MUDA');
                $mail->addAddress($email);
                $mail->Subject = 'Reset Password Anda';
                $mail->isHTML(true);

                // Link reset password dengan token baru
                $reset_link = "https://ppdb.site/smkhijaumuda/reset_password.php?token=" . urlencode($token);
                $mail->Body = "<p>Halo,</p>
                               <p>Klik link berikut untuk  mengatur ulang password Anda:</p>
                               <p><a href='$reset_link'>$reset_link</a></p>
                               <p>Link ini akan kedaluwarsa dalam 24 jam.</p>";

                if ($mail->send()) {
                    $success = '<span style="color: darkgreen;">Link reset password telah dikirim ke email Anda.</span>';
                } else {
                    $error = '<span style="color: red;">Gagal mengirim email. Coba lagi nanti.</span>';
                }
            } catch (Exception $e) {
                $error = "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            $error = "Gagal mengatur ulang token.";
        }
    } else {
        $error = "Email tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <h2>Lupa Kata Sandi</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Masukkan Email Anda" required>
            <button type="submit">Kirim Link Reset</button>
        </form>

        <div class="message">
            <a href="login.php">Kembali ke Login</a>
        </div>
    </div>
</body>
</html>
