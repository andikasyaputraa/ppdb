<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}
// Koneksi ke database
include 'includes/db.php';

// Menampilkan notifikasi jika parameter notif ada di URL
if (isset($_GET['notif']) && $_GET['notif'] == 'pembayaran') {
    echo "<script>alert('Selesaikan pembayaran anda!');</script>";
}

// Ambil nama lengkap dari sesi
$fullname = $_SESSION['fullname'];

// Kuota maksimal
$max_kuota = 500;

// Ambil jumlah pendaftar
$query = "SELECT COUNT(*) AS total_pendaftar FROM pendaftar";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_pendaftar = $row['total_pendaftar'];
$sisa_kuota = $max_kuota - $total_pendaftar;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa Dashboard - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/siswa_dashboard.css">

</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <h1>SMK HIJAU MUDA</h1>
        </div>   
    </div>
        <ul class="nav-menu">
            <li><a href="siswa_dashboard.php">Beranda</a></li>
            <li><a href="pendaftaran_siswa.php">Pendaftaran Siswa</a></li>
            <li><a href="pembayaran_siswa.php">Pembayaran</a></li>
            <li><a href="profile_siswa.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <div class="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </nav>
    
    <div class="container">
    <h2>Hallo, <?php echo htmlspecialchars($fullname); ?>!</h2>
    </div>
    <div class="container">
     <!-- Informasi PPDB -->
<section id="informasi-ppdb" style="margin: 50px 20px;">
    <h1 style="text-align: center; font-family: Arial, sans-serif;">Informasi PPDB</h1>
    <table>
        <thead>
            <tr>
                <th>Gel</th>
                <th>Tanggal Pendaftaran</th>
                <th>Kuota</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>1 Januari 2025 - 31 Januari 2025</td>
                <td>200 Siswa</td>
            </tr>
            <tr style="background-color: #f2f2f2;">
                <td>2</td>
                <td>1 Februari 2025 - 28 Februari 2025</td>
                <td>200 Siswa</td>
            </tr>
            <tr>
                <td>3</td>
                <td>1 Maret 2025 - 31 Maret 2025</td>
                <td>100 Siswa</td>
            </tr>
        </tbody>
    </table>
</section>
    <div class="info-section">
    
        <div class="info-box">
            <div>
                <p><strong>Total Pendaftar:</strong></p>
                <p><?php echo $total_pendaftar; ?> orang</p>
            </div>
            <div>
                <p><strong>Sisa Kuota:</strong></p>
                <p><?php echo $sisa_kuota; ?> orang</p>
            </div>
            <div class="clock">
                <p><strong>Jam Sekarang:</strong></p>
                <p id="current-time"></p>
            </div>
        </div>
    </div>
    <script>
        // Fungsi untuk memperbarui waktu real-time
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }

        // Jalankan fungsi setiap 1 detik
        setInterval(updateClock, 1000);

        // Panggil fungsi pertama kali saat halaman dimuat
        updateClock();
        
        // hamburger
      document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");

    hamburger.addEventListener("click", function () {
        navMenu.classList.toggle("active");
    });
});
    </script>
    <br>
    <br>
    <footer>
        <p>&copy; 2025 PPDB SMK HIJAU MUDA. All Rights Reserved.</p>
    </footer>
    </div>
   
</body>
</html>
