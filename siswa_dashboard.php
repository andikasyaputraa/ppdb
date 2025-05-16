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

// Ambil semua datainfo ppdb
$data_ppdb = mysqli_query($conn, "SELECT * FROM informasi_ppdb");

if (isset($_GET['hapus_informasi']) && $_GET['hapus_informasi'] == 'true') {
    $hapus = mysqli_query($conn, "DELETE FROM informasi_ppdb");

    if ($hapus) {
        echo "<script>alert('Semua data informasi PPDB berhasil dihapus.'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa Dashboard - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/siswa_dashboard.css">

</head>
<style>
      table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-family: Arial, sans-serif;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
</style>
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
<!-- Daftar Informasi PPDB, hanya tampil jika tidak ada parameter set_kuota atau informasi_ppdb -->
    <?php if (!isset($_GET['set_gelombang']) && !isset($_GET['set_kuota']) && !isset($_GET['edit']) && !isset($_GET['informasi_ppdb'])): ?>
        <h3>Daftar Biaya PPDB</h3>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>NO</th>
                <th>Jenis</th>
                <th>Nominal</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data_ppdb)) {
                echo "<tr>
                        <td>$no</td>
                        <td>{$row['jenis']}</td>
                        <td>Rp " . number_format($row['nominal'], 0, ',', '.') . "</td>
                    </tr>";
                $no++;
            }
            ?>
        </table>
        <?php endif; ?>
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
