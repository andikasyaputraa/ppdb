<?php
session_start();
// Memastikan pengguna sudah login dan memiliki role_id sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';

// Ambil data siswa beserta status pembayaran dari tabel pembayaran_siswa
$user_id = $_SESSION['user_id'];
$sql = "SELECT p.*, 
               COALESCE(ps.status_pembayaran, 'Belum Bayar') AS status_pembayaran
        FROM pendaftar p
        LEFT JOIN pembayaran_siswa ps ON p.user_id = ps.user_id
        WHERE p.user_id = '$user_id'
        ORDER BY ps.tanggal_bayar DESC
        LIMIT 1"; // Mengambil data pembayaran terbaru jika ada

// Eksekusi query dan ambil hasilnya
$result = $conn->query($sql);

// Cek apakah data ditemukan
if ($result && $result->num_rows > 0) {
    $siswa = $result->fetch_assoc();

    // Jika status pembayaran adalah 'Belum Bayar' dan ada pembayaran
    if ($siswa['status_pembayaran'] == "Belum Bayar") {
        // Cek apakah ada data pembayaran yang sudah dilakukan
        $pembayaran_sql = "SELECT * FROM pembayaran_siswa WHERE user_id = '$user_id' AND status_pembayaran = 'Telah Bayar' LIMIT 1";
        $pembayaran_result = $conn->query($pembayaran_sql);
        
        if ($pembayaran_result && $pembayaran_result->num_rows > 0) {
            // Pembayaran sudah dilakukan, update status pembayaran di tabel pendaftar
            $update_sql = "UPDATE pendaftar SET status_pembayaran = 'Telah Bayar' WHERE user_id = '$user_id'";
            $conn->query($update_sql);
            $siswa['status_pembayaran'] = 'Telah Bayar'; // Perbarui data yang ditampilkan
        }
    }
} else {
    echo "
    <div class='alert alert-danger' role='alert' style='padding: 15px; text-align: center; font-size: 20px; color:red; font-weight: bold;'>
        <i class='fa fa-exclamation-triangle' style='font-size: 60px;'></i> Tidak ada data, harap daftar terlebih dahulu
    </div>
    ";
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

    <div class="profile-container">
        <div class="head" style="display: flex;">
            <h2 class="profil">Profil</h2>
            <a href="edit_profil.php" class="btn-edit">Edit Profile</a>
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
                    <?php echo htmlspecialchars($siswa['status_pembayaran']); ?>
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
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
</script>
</body>
</html>
