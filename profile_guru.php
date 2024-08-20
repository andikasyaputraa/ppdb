<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id']; // ID dari session

// Koneksi ke database
include 'includes/db.php'; // Pastikan path benar

// Verifikasi nama kolom ID yang benar dari struktur tabel
$query = "SELECT nama, pendidikan_terakhir, mata_pelajaran, no_hp, alamat FROM guru WHERE id_guru = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data ditemukan
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Debugging information
    echo "Tidak ada data ditemukan untuk ID guru: " . htmlspecialchars($user_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Guru - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/profile_guru.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <ul class="nav-menu">
                <li><a href="guru_dashboard.php">Beranda</a></li>
                <li><a href="#">Mata Pelajaran anda</a></li>
                <li><a href="">Nilai</a></li>
                <li><a href="profile_guru.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Profil Saya</h2>
        <table class="profile-table">
            <tr>
                <th>Nama</th>
                <td><?php echo htmlspecialchars($user['nama']); ?></td>
            </tr>
            <tr>
                <th>Pendidikan Terakhir</th>
                <td><?php echo htmlspecialchars($user['pendidikan_terakhir']); ?></td>
            </tr>
            <tr>
                <th>Guru Mata Pelajaran</th>
                <td><?php echo htmlspecialchars($user['mata_pelajaran']); ?></td>
            </tr>
            <tr>
                <th>No. Hp</th>
                <td><?php echo htmlspecialchars($user['no_hp']); ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo htmlspecialchars($user['alamat']); ?></td>
            </tr>
        </table>
        <a class="btn-edit" href="lengkapi_profile.php">Lengkapi Profile</a>
    </div>
</body>
</html>
