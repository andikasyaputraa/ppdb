<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                    <h1>SMK HIJAU MUDA</h1>
                </div>
                
                
            </div>
            <ul class="nav-menu">
                <li><a href="admin_dashboard.php">Beranda</a></li>
                <li><a href="#">PPDB 2024</a></li>
                <li><a href="data_siswa.php">Data Siswa</a></li>
                <li><a href="data_guru.php">Data Guru</a></li>
                <li><a href="#">Jurusan</a></li>
                <li><a href="#">Prestasi</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="container">
    <h2>Profile</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere, itaque. Quae rerum inventore perspiciatis id possimus optio autem est atque illo numquam esse, adipisci praesentium sapiente, eveniet officia! In, odio!</p>

    <br>
    <H2>Jurusan</H2>
    <div class="container2">
        <div class="box">
            <a href="jurusan.php"><h3>Teknik Kendaraan Ringan (TKR)</h3></a>
            <br>
            <p>Program studi yang mempelajari tentang teknik perbaikan dan perawatan kendaraan ringan seperti mobil dan motor.</p>
        </div>
        <div class="box">
            <a href="jurusan.php"><h3>Teknik Komputer dan Jaringan (TKJ)</h3></a>
            <br>
            <p>Program studi yang mempelajari tentang teknik komputer, jaringan komputer, serta perancangan dan pengelolaan jaringan.</p>
        </div>
        <div class="box">
            <a href="jurusan.php"><h3>Manajemen Perkantoran (MP)</h3></a>
            <br>
            <p>Program studi yang mempelajari tentang administrasi perkantoran, pengelolaan arsip, dan manajemen kantor secara umum.</p>
        </div>     
        <div class="footer">
            &copy; 2024 SMK HIJAU MUDA. All rights reserved.
        </div>
    </div>



</body>
</html>
