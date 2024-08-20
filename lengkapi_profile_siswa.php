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
    <title>Lengkapi Profil - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/profile_siswa.css">
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <h1>SMK HIJAU MUDA</h1>
    </div>
    <ul class="nav-menu">
        <li><a href="siswa_dashboard.php">Beranda</a></li>
        <li><a href="profile_siswa.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Lengkapi Profil</h2>
    <form action="update_profile_siswa.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>

        <label for="nisn">NISN:</label>
        <input type="text" id="nisn" name="nisn" value="<?php echo htmlspecialchars($user['nisn']); ?>" required>

        <label for="kelas">Kelas:</label>
        <input type="text" id="kelas" name="kelas" value="<?php echo htmlspecialchars($user['kelas']); ?>" required>

        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($user['alamat']); ?></textarea>

        <label for="nama_bapak">Nama Bapak:</label>
        <input type="text" id="nama_bapak" name="nama_bapak" value="<?php echo htmlspecialchars($user['nama_bapak']); ?>" required>

        <label for="nama_ibu">Nama Ibu:</label>
        <input type="text" id="nama_ibu" name="nama_ibu" value="<?php echo htmlspecialchars($user['nama_ibu']); ?>" required>

        <label for="alamat_orangtua">Alamat Orang Tua:</label>
        <textarea id="alamat_orangtua" name="alamat_orangtua" required><?php echo htmlspecialchars($user['alamat_orangtua']); ?></textarea>

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
