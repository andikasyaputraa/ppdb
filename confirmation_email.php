<?php
// Menyertakan autoloader Composer
require '../vendor/autoload.php'; // Sesuaikan dengan path ke autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Menyertakan koneksi database
require_once 'includes/db.php';  // Menyesuaikan dengan lokasi file db.php

// Fungsi untuk mengirim email
function kirimEmail($idPendaftar, $status) {
    // Membuat instance PHPMailer
    $mail = new PHPMailer(true);
    
    // Ambil email pendaftar berdasarkan ID dari database
    global $conn;  // Pastikan $conn adalah variabel koneksi ke database
    $sql = "SELECT email FROM pendaftar WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPendaftar);  // Mengikat parameter ID
    $stmt->execute();
    $stmt->bind_result($emailTujuan);
    $stmt->fetch();
    $stmt->close();

    // Jika email tidak ditemukan, tampilkan error
    if (!$emailTujuan) {
        echo "Email tidak ditemukan!";
        return;
    }

    try {
        // Menggunakan SMTP
        $mail->isSMTP();
        $mail->Host = 'mail.onlineppdb.com';  // SMTP server Anda
        $mail->SMTPAuth = true;
        $mail->Username = 'ppdb7395';  // Ganti dengan username SMTP Anda
        $mail->Password = '@zka18Mei23';  // Ganti dengan password SMTP Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS
        $mail->Port = 587;

        // Menyalakan debug level 2
        $mail->SMTPDebug = 2;  // Menyalakan debug level 2 untuk melihat log lebih detail

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

        // Mengirim email
        if ($mail->send()) {
            echo 'Email berhasil dikirim';
        } else {
            echo 'Gagal mengirim email';
        }
    } catch (Exception $e) {
        echo "Pesan tidak dapat dikirim. Kesalahan Mailer: {$mail->ErrorInfo}";
    }
}

// Contoh penggunaan: kirim email kepada pendaftar dengan ID 1 dan status 'terima'
$idPendaftar = 1;  // Ganti dengan ID pendaftar yang sesuai
$status = 'terima'; // Ganti dengan 'tolak' atau 'terima' berdasarkan keputusan

// Kirim email dengan status yang sesuai
kirimEmail($idPendaftar, $status);
