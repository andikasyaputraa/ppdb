<?php
session_start();
// Memastikan pengguna sudah login dan memiliki role_id sebagai admin atau siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';

// Ambil ID dari URL jika tersedia
$user_id = isset($_GET['id']) ? intval($_GET['id']) : $_SESSION['user_id']; 

// Ambil data siswa berdasarkan user_id dari tabel pendaftar
$sql = "SELECT * FROM pendaftar WHERE user_id = '$user_id'";
$result = $conn->query($sql);

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $siswa = $result->fetch_assoc();

    // Query status pembayaran dari tabel pembayaran_siswa berdasarkan user_id
    $pembayaran_sql = "SELECT status_pembayaran FROM pembayaran_siswa WHERE user_id = '$user_id'";
    $pembayaran_result = $conn->query($pembayaran_sql);

    // Jika status pembayaran ditemukan
    if ($pembayaran_result->num_rows > 0) {
        $pembayaran = $pembayaran_result->fetch_assoc();
        $status_pembayaran = $pembayaran['status_pembayaran'];
    } else {
        $status_pembayaran = "Belum Bayar"; // Default jika tidak ada data pembayaran
    }
} else {
    echo "Data tidak ditemukan.";
    exit();
}

// Mendapatkan nama lengkap dari sesi
$fullname = $siswa['nama'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Siswa - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/profile_siswa.css">
</head>
<body>
    <header>
    <nav class="navbar">
        <div class="logo">
            <h1>SMK HIJAU MUDA</h1>
        </div>
        <ul class="nav-menu">
            <li><a href="admin_dashboard.php">Beranda</a></li>
            <li><a href="data_pendaftar_admin.php">Data Calon Siswa</a></li>
            <li><a href="data_pembayaran.php">Data Pembayaran</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        <!-- Hanya satu hamburger menu -->
        <div class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>
</header>
<div class="profile-container">
        <div class="head" style="display: flex;">
            <h2 class="profil">Data Calon Siswa</h2>
        </div>
        <table>
        <tr>
            <th>Foto</th>
            <td>
            <?php if (!empty($siswa['foto'])) { ?>
                <a href="uploads/<?= htmlspecialchars($siswa['foto']); ?>" target="_blank" class="btn-view">Lihat</a>
                <a href="uploads/<?= htmlspecialchars($siswa['foto']); ?>" download class="btn-download">Download</a>
            <?php } ?>
             </td>

            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td><?php echo htmlspecialchars($siswa['nama']); ?></td>
            </tr>
            <tr>
                <th>email</th>
                <td><?php echo htmlspecialchars($siswa['email']); ?></td>
            </tr>
            <tr>
                <th>no telpon</th>
                <td><?php echo htmlspecialchars($siswa['telp']); ?></td>
            </tr>
            <tr>
                <th>NIK</th>
                <td><?php echo htmlspecialchars($siswa['nik']); ?></td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td><?php echo htmlspecialchars($siswa['tempat_lahir']); ?></td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td><?php echo htmlspecialchars($siswa['tanggal_lahir']); ?></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td><?php echo htmlspecialchars($siswa['jenis_kelamin']); ?></td>
            </tr>
            <tr>
                <th>Agama</th>
                <td><?php echo htmlspecialchars($siswa['agama']); ?></td>
            </tr>
            <tr>
                <th>Anak Ke-</th>
                <td><?php echo htmlspecialchars($siswa['anak_ke']); ?></td>
            </tr>
            <tr>
                <th>Status Keluarga</th>
                <td><?php echo htmlspecialchars($siswa['status_keluarga']); ?></td>
            </tr>
            <tr>
                <th>NISN</th>
                <td><?php echo htmlspecialchars($siswa['nisn']); ?></td>
            </tr>
            <tr>
                <th>Kartu Keluarga (KK)</th>
                <td>
                     <?php if (!empty($siswa['kk'])) { ?>
                        <a href="uploads/<?= htmlspecialchars($siswa['kk']); ?>" target="_blank" class="btn-view">Lihat</a>
                        <a href="uploads/<?= htmlspecialchars($siswa['kk']); ?>" download class="btn-download">Download</a>
                    <?php } ?>
             </td>
            </tr>
            <tr>
                <th>Akta Kelahiran</th>
                <td>
                   <?php if (!empty($siswa['akta'])) { ?>
                         <a href="uploads/<?= htmlspecialchars($siswa['akta']); ?>" target="_blank" class="btn-view">Lihat</a>
                         <a href="uploads/<?= htmlspecialchars($siswa['akta']); ?>" download class="btn-download">Download</a>
                    <?php } ?>
             </td>
            </tr>
            <tr>
                <th>Surat Keterangan Lulus (SKL)</th>
                <td>
                     <?php if (!empty($siswa['skl'])) { ?>
                         <a href="uploads/<?= htmlspecialchars($siswa['skl']); ?>" target="_blank" class="btn-view">Lihat</a>
                         <a href="uploads/<?= htmlspecialchars($siswa['skl']); ?>" download class="btn-download">Download</a>
                    <?php } ?>
             </td>
            </tr>
            <tr>
                <th>Alamat Rumah</th>
                <td><?php echo htmlspecialchars($siswa['alamat']); ?></td>
            </tr>
            <tr>
                <th>Asal Sekolah</th>
                <td><?php echo htmlspecialchars($siswa['asal_sekolah']); ?></td>
            </tr>
            <tr>
                <th>Alamat Sekolah</th>
                <td><?php echo htmlspecialchars($siswa['Alamat_Sekolah']); ?></td>
            </tr>
            <tr>
                <th>NPSN Sekolah</th>
                <td><?php echo htmlspecialchars($siswa['npsn']); ?></td>
            </tr>
            <tr>
                <th>Ayah Kandung</th>
                <td><?php echo htmlspecialchars($siswa['nama_ayah']); ?></td>
            </tr>
            <tr>
                <th>Ibu Kandung</th>
                <td><?php echo htmlspecialchars($siswa['nama_ibu']); ?></td>
            </tr>
            <tr>
                <th>Pekerjaan Ayah</th>
                <td><?php echo htmlspecialchars($siswa['pekerjaan_ayah']); ?></td>
            </tr>
            <tr>
                <th>Pekerjaan ibu</th>
                <td><?php echo htmlspecialchars($siswa['pekerjaan_ibu']); ?></td>
            </tr>
            <tr>
                <th>Pendapatan Orang Tua</th>
                <td><?php 
                    if ($siswa['gaji_orang_tua'] !== NULL && $siswa['gaji_orang_tua'] > 0) {
                        echo "Rp " . number_format($siswa['gaji_orang_tua'], 2, ',', '.');
                    } else {
                        echo "Belum diisi";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td><?php echo htmlspecialchars($siswa['jurusan']); ?></td>
            </tr>
            <tr>
                <th>Gelombang</th>
                <td><?php echo htmlspecialchars($siswa['gelombang']); ?></td>
            </tr>
            <tr>
                <th>Rekomendasi</th>
                <td><?php echo htmlspecialchars($siswa['rekomendasi']); ?></td>
            </tr>
            <tr>
                <th>Status Pendaftaran</th>
                <td><?php echo htmlspecialchars($siswa['status_pendaftaran']); ?></td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td style="color: green; font-weight: bold;">
                    <?php echo htmlspecialchars($status_pembayaran); ?>
                </td>
            </tr>
        </table>
    </div>

    <br>
    <footer>
        <p>&copy; 2025 PPDB SMK HIJAU MUDA. All Rights Reserved.</p>
    </footer>
    <br><br>
    
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");

    if (hamburger && navMenu) {
        hamburger.addEventListener("click", function () {
            navMenu.classList.toggle("active");
        });
    }
});


 </script>
</body>
</html>