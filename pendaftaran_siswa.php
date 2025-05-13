<?php
session_start();

// Memastikan pengguna sudah login dan memiliki role_id sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';


// Ambil data admin berdasarkan admin_id
$query_admin = "SELECT * FROM admin WHERE id = ?";
$stmt_admin = $conn->prepare($query_admin);
$stmt_admin->bind_param("i", $admin_id);  // Bind parameter admin_id
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();
$data_admin = $result_admin->fetch_assoc();

$user_id = $_SESSION['user_id'];

// Query hanya untuk user yang sedang login
$query = "SELECT p.*, u.*, a.fullname AS nama_admin
          FROM pendaftar p
          LEFT JOIN users u ON p.user_id = u.id
          LEFT JOIN admin a ON p.admin_id = a.id
          WHERE p.user_id = $user_id"; // Menyesuaikan user_id dengan sesi pengguna yang login

$result = mysqli_query($conn, $query);

$data = null; // Mencegah error jika tidak ada data
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
}

// Fungsi untuk mengonversi halaman ini ke PDF
if (isset($_GET['export_pdf'])) {
    // Include TCPDF library
    require_once('vendor/tecnickcom/tcpdf/tcpdf.php'); // Sesuaikan path ke TCPDF

    // Membuat objek PDF
    $pdf = new TCPDF();
    
    // Menambahkan halaman
    $pdf->AddPage();

    // Mengatur font
    $pdf->SetFont('helvetica', 'B', 14);

    //logo
    $logoPath = 'logo.jpg'; // Ganti dengan path yang sesuai ke logo SMK
    $pdf->Image($logoPath, 10, 10, 30); // Posisi (10,10) dan ukuran (30) logo

    // Menambahkan judul
    $pdf->Cell(200, 10, 'BUKTI FISIK PENDAFTARAN PESERTA DIDIK BARU', 0, 1, 'C');
    $pdf->Cell(200, 10, 'SMK HIJAU MUDA', 0, 1, 'C');
    $pdf->Cell(200, 10, 'TAHUN AJARAN 2025/2026', 0, 1, 'C');

    $pdf->Ln(10); // Memberikan jarak

    // Mengatur font untuk data
    $pdf->SetFont('helvetica', '', 12);

    // Membuat tabel
    $pdf->SetFillColor(220, 220, 220); // Warna latar tabel
    $pdf->Cell(40, 10, 'Nama', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['fullname'], 1, 1, 'L');
    
    $pdf->Cell(40, 10, 'User ID', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['user_id'], 1, 1, 'L');
    
    $pdf->Cell(40, 10, 'Email', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['email'] ?? '-', 1, 1, 'L');
    
    $pdf->Cell(40, 10, 'Jurusan Pilihan', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['jurusan'] ?? '-', 1, 1, 'L');
    
    $pdf->Cell(40, 10, 'Status Pendaftaran', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['status_pendaftaran'] ?? '-', 1, 1, 'L');
    
    $pdf->Cell(40, 10, 'Operator PPDB', 1, 0, 'L', 1);
    $pdf->Cell(0, 10, $data['nama_admin'] ?? '-', 1, 1, 'L');

    // Menambahkan jarak sebelum TTD
    $pdf->Ln(10);

    // Menambahkan teks untuk TTD
    $pdf->Cell(0, 10, 'Panitia PPDB', 0, 1, 'L'); 
    $pdf->Ln(10);
    $pdf->Cell(0, 10, '..............................................................', 0, 1, 'L'); // Garis TTD  

    // Output PDF
    $pdf->Output('Bukti Pendaftaran.pdf', 'D');  // Nama file PDF dan mode download
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
    <link rel="stylesheet" href="css/pendaftaran.css">
    <style>
        
        .btn:hover {
            background-color: #539261;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="logo">
        <h1>SMK HIJAU MUDA</h1>
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
        </div>
</nav>

<br><br><br>

<div class="container">
    <h2 style="text-align: center;">Pendaftaran PPDB 2025/2026 SMK Hijau Muda </h2>

    <?php if ($data): ?>
        <table>
            <tr>
                <td>User ID</td>
                <td><?= htmlspecialchars($data['user_id']) ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><?= htmlspecialchars($data['fullname']) ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= htmlspecialchars($data['email'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Jurusan Pilihan</td>
                <td><?= htmlspecialchars($data['jurusan'] ?? '-') ?></td>
            </tr>
            <tr>
                <td>Status Pendaftaran</td>
                <td><?= htmlspecialchars($data['status_pendaftaran'] ?? '-') ?></td>
            </tr>
         <tr>
            <td>Operator PPDB</td>
            <td><?= !empty($data['admin_id']) ? htmlspecialchars($data['nama_admin']) : '-' ?></td>
        </tr>
        </table>
    <?php else: ?>
        <div class="alert">
            <p>Belum ada data. Silakan lakukan pendaftaran terlebih dahulu.</p>
        </div>
    <?php endif; ?>

    <div class="center-buttons">
    <a href="FormPpdb.php" class="btn">Daftar Sekarang</a>
    <a href="?export_pdf=true" class="btn">Cetak Bukti</a>
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
