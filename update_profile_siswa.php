<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';

$user_id = $_POST['user_id'];
$nama = $_POST['nama'];
$nisn = $_POST['nisn'];
$kelas = $_POST['kelas'];
$alamat = $_POST['alamat'];
$nama_bapak = $_POST['nama_bapak'];
$nama_ibu = $_POST['nama_ibu'];
$alamat_orangtua = $_POST['alamat_orangtua'];

// Update data di database
$query = "UPDATE siswa SET nama=?, nisn=?, kelas=?, alamat=?, nama_bapak=?, nama_ibu=?, alamat_orangtua=? WHERE id_siswa=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssi", $nama, $nisn, $kelas, $alamat, $nama_bapak, $nama_ibu, $alamat_orangtua, $user_id);

if ($stmt->execute()) {
    header("Location: profile_siswa.php");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}
?>
