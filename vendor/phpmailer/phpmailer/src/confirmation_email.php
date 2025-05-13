<?php
// Menyertakan autoloader Composer
require '../vendor/autoload.php';  // Sesuaikan dengan path autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Menyertakan koneksi database
require_once 'includes/db.php';  // Pastikan path ke db.php benar

// Fungsi untuk mengirim email
function kirimEmail($idPendaftar, $status) {
    // Membuat instance PHPMailer
    $mail = new PHPMailer(true);
    
    // Ambil email pendaftar berdasarkan ID dari database
    global $conn;
    $sql = "SELECT email FROM pendaftar WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPendaftar);  // Mengikat parameter ID
    $stmt->execute();
    $stmt->bind_result($emailTujuan);
    $stmt->fetch();
    $stmt->close();

    if (!$emailTujuan) {
        echo json_encode(['success' => false, 'message' => 'Email tidak ditemukan!']);
        return;
    }

    try {
        // Menggunakan SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.onlineppdb.com';  // SMTP server Anda
        $mail->SMTPAuth = true;
        $mail->Username = 'ppdb7395';  // Ganti dengan username SMTP Anda
        $mail->Password = '@zka18Mei23';  // Ganti dengan password SMTP Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Pengaturan pengirim dan penerima
        $mail->setFrom('ppdb7395@onlineppdb.com', 'SMK HIJAU MUDA');  // Alamat pengirim
        $mail->addAddress($emailTujuan);  // Alamat email tujuan

        // Tentukan subjek dan isi email berdasarkan status
        $mail->isHTML(true);  // Menggunakan format HTML untuk body email

        if ($status == 'terima') {
            $mail->Subject = 'Selamat, Pendaftaran Anda Diterima!';
            $mail->Body = '<h1>Selamat!</h1><p>Pendaftaran Anda telah diterima. Anda dapat mengikuti kegiatan selanjutnya.</p>';
        } else {
            $mail->Subject = 'Maaf, Pendaftaran Anda Ditolak';
            $mail->Body = '<h1>Maaf!</h1><p>Pendaftaran Anda ditolak. Silakan coba lagi di kesempatan lain.</p>';
        }

        if ($mail->send()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengirim email']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, '_
