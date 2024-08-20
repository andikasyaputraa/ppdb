<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari database
$user_id = $_SESSION['user_id'];

// Koneksi ke database
include 'includes/db.php'; // Pastikan path sesuai dengan lokasi file

// Ambil data dari database
$query = "SELECT nama, pendidikan_terakhir, mata_pelajaran, no_hp, alamat FROM guru WHERE id_guru = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Tidak ada data ditemukan untuk ID guru: " . htmlspecialchars($user_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil - SMK HIJAU MUDA</title>
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
        <h2>Lengkapi Profil</h2>
        <form action="update_profile.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>

            <label for="pendidikan">Pendidikan Terakhir:</label>
            <input type="text" id="pendidikan" name="pendidikan" value="<?php echo htmlspecialchars($user['pendidikan_terakhir']); ?>" required>

            <label for="mata_pelajaran">Guru Mata Pelajaran:</label>
            <input type="text" id="mata_pelajaran" name="mata_pelajaran" value="<?php echo htmlspecialchars($user['mata_pelajaran']); ?>" required>

            <label for="no_hp">No. Hp:</label>
            <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($user['no_hp']); ?>" required>

            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($user['alamat']); ?></textarea>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
