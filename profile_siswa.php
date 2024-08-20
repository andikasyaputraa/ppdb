<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];

// Koneksi ke database
include 'includes/db.php';

// Ambil data dari database
$query = "SELECT nama, nisn, kelas, alamat, nama_bapak, nama_ibu, alamat_orangtua FROM siswa WHERE id_siswa = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Tidak ada data ditemukan untuk ID siswa: " . htmlspecialchars($user_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Siswa - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/profile_siswa.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <h1>SMK HIJAU MUDA</h1>
    </div>
    <ul class="nav-menu">
        <li><a href="siswa_dashboard.php">Beranda</a></li>
        <li><a href="siswa_dashboard.php">kelas</a></li>
        <li><a href="siswa_dashboard.php">ujian</a></li>
        <li><a href="profile_siswa.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Profile Siswa</h2>
    <table>
        <tr>
            <th>Nama:</th>
            <td><?php echo htmlspecialchars($user['nama']); ?></td>
        </tr>
        <tr>
            <th>NISN:</th>
            <td><?php echo htmlspecialchars($user['nisn']); ?></td>
        </tr>
        <tr>
            <th>Kelas:</th>
            <td><?php echo htmlspecialchars($user['kelas']); ?></td>
        </tr>
        <tr>
            <th>Alamat:</th>
            <td><?php echo htmlspecialchars($user['alamat']); ?></td>
        </tr>
        <tr>
            <th>Nama Bapak:</th>
            <td><?php echo htmlspecialchars($user['nama_bapak']); ?></td>
        </tr>
        <tr>
            <th>Nama Ibu:</th>
            <td><?php echo htmlspecialchars($user['nama_ibu']); ?></td>
        </tr>
        <tr>
            <th>Alamat Orang Tua:</th>
            <td><?php echo htmlspecialchars($user['alamat_orangtua']); ?></td>
        </tr>
    </table>
    <a href="lengkapi_profile_siswa.php" class="btn">Lengkapi Profil</a>
</div>
</body>
</html>
