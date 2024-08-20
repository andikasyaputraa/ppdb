<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}
// Ambil nama pengguna dari sesi
$username = $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru Dashboard - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
<header>
        <nav class="navbar">
            <div class="logo">
                    <h1>SMK HIJAU MUDA</h1>
            </div>    
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
        <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    </div>
    <div class="footer">
            &copy; 2024 SMK HIJAU MUDA. by Muhammad Andika Anjas Syaputra
        </div>
</body>
</html>
