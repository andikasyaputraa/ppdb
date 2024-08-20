<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Ambil data dari form
$user_id = $_POST['user_id'];
$nama = $_POST['nama'];
$pendidikan = $_POST['pendidikan'];
$mata_pelajaran = $_POST['mata_pelajaran'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

// Koneksi ke database
include 'includes/db.php'; // Pastikan path sesuai dengan lokasi file

// Update data di database
$query = "UPDATE guru SET nama = ?, pendidikan_terakhir = ?, mata_pelajaran = ?, no_hp = ?, alamat = ? WHERE id_guru = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssi", $nama, $pendidikan, $mata_pelajaran, $no_hp, $alamat, $user_id);

if ($stmt->execute()) {
    // Redirect ke halaman profil guru setelah berhasil update
    header("Location: profile_guru.php");
    exit();
} else {
    echo "Terjadi kesalahan saat memperbarui data: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
