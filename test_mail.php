<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'syaputramuhandika3@gmail.com'; // Ganti dengan email Anda
    $mail->Password = ''; // Ganti dengan Password Aplikasi Google
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your_email@gmail.com', 'SMK HIJAU MUDA');
    $mail->addAddress('andikasyaputra818@gmail.com'); // Ganti dengan email tujuan

    $mail->isHTML(true);
    $mail->Subject = 'Tes PHPMailer';
    $mail->Body = 'Jika Anda menerima email ini, berarti PHPMailer berhasil!';

    $mail->send();
    echo 'Email berhasil dikirim!';
} catch (Exception $e) {
    echo "Gagal mengirim email. Error: {$mail->ErrorInfo}";
}
?>
