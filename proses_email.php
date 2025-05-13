<?php
require '../vendor/autoload.php'; // Pastikan PHPMailer tersedia
require '../db.php'; // Koneksi database

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL); // Tampilkan semua error untuk debugging
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['action'])) {
    $user_id = $_POST['id'];
    $status = $_POST['action'];

    // Pastikan koneksi database aktif
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Ambil email berdasarkan user_id dari tabel pendaftar
    $query = "SELECT email FROM pendaftar WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error dalam query: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $emailTujuan = $row['email'];
        $subject = ($status == 'terima') ? "Pendaftaran Anda Diterima" : "Pendaftaran Anda Ditolak";
        $message = ($status == 'terima') ? 
            "<h3>Selamat!</h3><p>Pendaftaran Anda telah diterima. Silakan login ke sistem.</p>" : 
            "<h3>Mohon Maaf!</h3><p>Pendaftaran Anda tidak dapat diterima.</p>";

        if (kirimEmail($emailTujuan, $subject, $message)) {
            echo "<script>alert('Email berhasil dikirim ke $emailTujuan'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal mengirim email'); window.location.href='admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan untuk user_id $user_id'); window.location.href='admin_dashboard.php';</script>";
    }

    $stmt->close();
    $conn->close();
}

// Fungsi untuk mengirim email
function kirimEmail($emailTujuan, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'mail.onlineppdb.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ppdb7395@onlineppdb.com';
        $mail->Password = '@zka18Mei23';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('ppdb7395@onlineppdb.com', 'SMK HIJAU MUDA');
        $mail->addAddress($emailTujuan);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        return $mail->send();
    } catch (Exception $e) {
        error_log("Error saat mengirim email: " . $mail->ErrorInfo);
        return false;
    }
}
?>
