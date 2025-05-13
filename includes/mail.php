<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan PHPMailer sudah diinstal

function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    
    try {
        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'syaputramuhandika3@gmail.com'; // Ganti dengan email Anda
        $mail->Password = '#'; // Ganti dengan password aplikasi Gmail Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengirim & Penerima
        $mail->setFrom('noreply@yourwebsite.com', 'SMK HIJAU MUDA');
        $mail->addAddress($email);

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Anda';
        $reset_link = "http://localhost/ppdbsmkhm/reset_password.php";
        $mail->Body = "Klik link berikut untuk mereset password Anda: <a href='$reset_link'>$reset_link</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
