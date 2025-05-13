<?php
session_start();

// Memastikan pengguna sudah login dan memiliki role_id sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';

$user_id = $_SESSION['user_id'];

// Ambil data dari tabel `pendaftar` dan `pembayaran_siswa`
$query = "SELECT p.user_id, p.nama, ps.jumlah_bayar, ps.metode_pembayaran, ps.tanggal_bayar, ps.bukti_pembayaran, ps.status_pembayaran 
          FROM pendaftar p
          LEFT JOIN pembayaran_siswa ps ON p.user_id = ps.user_id
          WHERE p.user_id = '$user_id'";

$result = mysqli_query($conn, $query);


// Periksa apakah data ditemukan
$data = null; // Mencegah error jika tidak ada data
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
}

// Mengekspor ke PDF jika tombol diklik
if (isset($_GET['export_pdf'])) {
    // Include TCPDF library
    require_once('vendor/tecnickcom/tcpdf/tcpdf.php'); // Sesuaikan path ke TCPDF

    // Membuat objek PDF
    $pdf = new TCPDF();
    
    // Menambahkan halaman
    $pdf->AddPage();

    
    //logo
    $logoPath = 'logo.jpg'; // Ganti dengan path yang sesuai ke logo SMK
    $pdf->Image($logoPath, 10, 10, 30); // Posisi (10,10) dan ukuran (30) logo

    // Menambahkan judul
    $pdf->Cell(200, 10, 'BUKTI FISIK PEMBAYARAN PESERTA DIDIK BARU', 0, 1, 'C');
    $pdf->Cell(200, 10, 'SMK HIJAU MUDA', 0, 1, 'C');
    $pdf->Cell(200, 10, 'TAHUN AJARAN 2025/2026', 0, 1, 'C');

    $pdf->Ln(10);

    // Mengatur font untuk data
    $pdf->SetFont('helvetica', '', 12);

    // Membuat tabel
    $pdf->SetFillColor(220, 220, 220); // Warna latar tabel
    $pdf->Cell(50, 10, 'Nama', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['nama'], 1, 1, 'L'); // Text rata kiri

    $pdf->Cell(50, 10, 'User ID', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['user_id'], 1, 1, 'L'); // Text rata kiri

    $pdf->Cell(50, 10, 'Jumlah', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['jumlah_bayar'] ?? '-', 1, 1, 'L'); // Text rata kiri

    $pdf->Cell(50, 10, 'Metode Pembayaran', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['metode_pembayaran'] ?? '-', 1, 1, 'L'); // Text rata kiri

    $pdf->Cell(50, 10, 'Tanggal', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['tanggal_bayar'] ?? '-', 1, 1, 'L'); // Text rata kiri

    $pdf->Cell(50, 10, 'Bukti Pembayaran', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['bukti_pembayaran'] ?? '-', 1, 1, 'L'); // Text rata kiri

    $pdf->Cell(50, 10, 'Status Pembayaran', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['status_pembayaran'] ?? 'Belum Bayar', 1, 1, 'L'); // Text rata kiri

    // Menambahkan jarak sebelum TTD
    $pdf->Ln(10);

    // Menambahkan teks untuk TTD
    $pdf->Cell(0, 10, 'Panitia PPDB', 0, 1, 'L'); // Teks rata kiri
    $pdf->Ln(10);
    $pdf->Cell(0, 10, '..............................................................', 0, 1, 'L'); // Garis TTD rata kiri

    // Output PDF
    $pdf->Output('Bukti Lunas Pembayaran.pdf', 'D');  // Nama file PDF dan mode download
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Siswa</title>
    <link rel="stylesheet" href="css/pembayaran_siswa.css">
    <style>
        /* Style notifikasi */
        .alert {
            background-color: #ffdddd;
            border-left: 6px solid #f44336;
            margin: 20px 0;
            padding: 15px;
            color: #d8000c;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }

        /* Style tombol */
        .btn {
            display: inline-block;
            background-color: rgb(105, 188, 144);
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
              background-color: #539261;
              transform: translateY(-3px);
        }

        /* Style tabel */
        table {
            width: 60%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        th, td {
            padding: 12px;
            border: 1px solid black;
            text-align: left;
        }
        td:first-child {
            font-weight: bold;
            background-color: #f9f9f9;
            width: 30%;
        }

        /* Pusatkan tombol */
        .center-button {
            text-align: center;
            margin-top: 20px;
        }
    </style>
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

<br><br><br>

<div class="container">
    <h2 style="text-align: center;">Data Pembayaran Siswa</h2>

    <?php if ($data): ?>
        <table>
            <tr>
                <td>User ID</td>
                <td><?= htmlspecialchars($data['user_id']) ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><?= htmlspecialchars($data['nama']) ?></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><?= htmlspecialchars($data['jumlah_bayar'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Metode Pembayaran</td>
                <td><?= htmlspecialchars($data['metode_pembayaran'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td><?= htmlspecialchars($data['tanggal_bayar'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Bukti Pembayaran</td>
                <td>
                    <?php if (!empty($data['bukti_pembayaran'])): ?>
                        <a href="uploads/<?= htmlspecialchars($data['bukti_pembayaran']) ?>" target="_blank">Lihat Bukti</a>
                        <a href="uploads/<?= htmlspecialchars($data['bukti_pembayaran']) ?>" download>Download</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td><?= htmlspecialchars($data['status_pembayaran'] ?? 'Belum Bayar') ?></td>
            </tr>
        </table>
    <?php else: ?>
        <div class="alert">
            <p>Belum ada data. Silakan lakukan pendaftaran terlebih dahulu.</p>
        </div>
    <?php endif; ?>

    <div class="center-button">
        <a href="pembayaran.php" class="btn">Lakukan Pembayaran</a>
        <a href="pembayaran_siswa.php?export_pdf=true" class="btn">Cetak bukti</a>
    </div>
</div>
<script>
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>

</body>
</html>
