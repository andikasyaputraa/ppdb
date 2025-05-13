<?php
session_start();
// Memastikan pengguna sudah login dan memiliki role_id sebagai siswa
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
include 'includes/db.php';

// Ambil data siswa berdasarkan user_id yang disimpan di sesi
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM pendaftar WHERE user_id = '$user_id'";
$result = $conn->query($sql);

// Cek apakah data ditemukan
if ($result->num_rows > 0) {
    $siswa = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit();
}

// Proses penyimpanan data setelah pengeditan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $tempat_lahir = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $agama = mysqli_real_escape_string($conn, $_POST['agama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $asal_sekolah = mysqli_real_escape_string($conn, $_POST['asal_sekolah']);
    $Alamat_Sekolah = mysqli_real_escape_string($conn, $_POST['Alamat_Sekolah']);
    $npsn = mysqli_real_escape_string($conn, $_POST['npsn']);
    $nama_ayah = mysqli_real_escape_string($conn, $_POST['nama_ayah']);
    $nama_ibu = mysqli_real_escape_string($conn, $_POST['nama_ibu']);
    $pekerjaan_ayah = mysqli_real_escape_string($conn, $_POST['pekerjaan_ayah']);
    $pekerjaan_ibu = mysqli_real_escape_string($conn, $_POST['pekerjaan_ibu']);
    $gaji_orang_tua = mysqli_real_escape_string($conn, $_POST['gaji_orang_tua']);


   // Folder penyimpanan file
$uploadDir = "uploads/"; // folder uploads hanya satu kali
$allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
$maxSize = 2 * 1024 * 1024; // 2MB

// Fungsi upload
function uploadFile($file, $existing_file, $uploadDir, $allowedTypes, $maxSize) {
    if (!empty($file["name"]) && $file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file["name"]);
        $fileName = preg_replace('/\s+/', '_', $fileName); // Ganti spasi jadi _
        $fileTmp = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validasi ekstensi dan ukuran
        if (in_array($fileExt, $allowedTypes) && $fileSize <= $maxSize) {
            // Membuat nama file baru dengan unik ID
            $newFileName = uniqid() . "_" . $fileName;
            $destination = $uploadDir . $newFileName; // Path lengkap ke direktori upload

            // Jika berhasil upload, kembalikan nama file baru
            if (move_uploaded_file($fileTmp, $destination)) {
                return $newFileName; // Simpan hanya nama file yang unik
            }
        }
    }

    // Jika gagal upload, kembalikan file lama (misalnya dari database)
    return $existing_file;
}

// Contoh penggunaan
$foto = uploadFile($_FILES['foto'], $siswa['foto'], $uploadDir, $allowedTypes, $maxSize);
$kk   = uploadFile($_FILES['kk'], $siswa['kk'], $uploadDir, $allowedTypes, $maxSize);
$akta = uploadFile($_FILES['akta'], $siswa['akta'], $uploadDir, $allowedTypes, $maxSize);
$skl  = uploadFile($_FILES['skl'], $siswa['skl'], $uploadDir, $allowedTypes, $maxSize);


    
    $update_sql = "UPDATE pendaftar SET 
    nama = '$nama', email='$email', telp ='$telp', nik = '$nik', tempat_lahir = '$tempat_lahir',
    tanggal_lahir = '$tanggal_lahir', jenis_kelamin = '$jenis_kelamin', agama = '$agama',
    alamat = '$alamat', asal_sekolah = '$asal_sekolah', Alamat_Sekolah = '$Alamat_Sekolah', npsn= '$npsn', nama_ayah = '$nama_ayah',
    nama_ibu = '$nama_ibu', pekerjaan_ayah = '$pekerjaan_ayah', pekerjaan_ibu = '$pekerjaan_ibu',
    gaji_orang_tua = '$gaji_orang_tua', foto = '$foto', kk = '$kk', akta = '$akta', skl = '$skl'
    WHERE user_id = '$user_id'";
    
    if ($conn->query($update_sql) === TRUE) {
        header("Location: profile_siswa.php?success=1");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Siswa - SMK HIJAU MUDA</title>
    <link rel="stylesheet" href="css/edit_profil.css">
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
    </nav>

    <div class="profile-container">
        <h2>Edit Profil</h2>
        <form  method="POST" class="edit-form" enctype="multipart/form-data" class="edit-form">
             <!-- Upload Foto -->
            <label for="foto">Foto Siswa</label>
            <input type="file" name="foto" accept="image/*">
            <?php if (!empty($siswa['foto'])) { echo "<p>File saat ini: <a href='".$siswa['foto']."' target='_blank'>Lihat</a></p>"; } ?>
            
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>
            <label for="email">email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($siswa['email']); ?>" required>
            <label for="telp">Nomor telepon</label>
            <input type="text" name="telp" value="<?php echo htmlspecialchars($siswa['telp']); ?>" required>
            <label for="nik">NIK</label>
            <input type="text" name="nik" value="<?php echo htmlspecialchars($siswa['nik']); ?>" required>
            <label for="tempat_lahir">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" value="<?php echo htmlspecialchars($siswa['tempat_lahir']); ?>" required>
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars($siswa['tanggal_lahir']); ?>" required>
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <input type="text" name="jenis_kelamin" value="<?php echo htmlspecialchars($siswa['jenis_kelamin']); ?>" required>
            <label for="agama">Agama</label>
            <input type="text" name="agama" value="<?php echo htmlspecialchars($siswa['agama']); ?>" required>
            <label for="alamat">Alamat Rumah</label>
            <input type="text" name="alamat" value="<?php echo htmlspecialchars($siswa['alamat']); ?>" required>
            <label for="asal_sekolah">Asal Sekolah</label>
            <input type="text" name="asal_sekolah" value="<?php echo htmlspecialchars($siswa['asal_sekolah']); ?>" required>
            <label for="Alamat_Sekolah">Alamat Sekolah Asal</label>
            <input type="text" name="Alamat_Sekolah" value="<?php echo htmlspecialchars($siswa['Alamat_Sekolah']); ?>" required>
            
            <!-- Upload Akta Kelahiran -->
            <label for="kk">Kartu Keluarga</label>
            <input type="file" name="kk" accept="application/pdf, image/*">
            <?php if (!empty($siswa['kk'])) { echo "<p>File saat ini: <a href='".$siswa['kk']."' target='_blank'>Lihat</a></p>"; } ?>
            
            <label for="akta">Akta Kelahiran</label>
            <input type="file" name="akta" accept="application/pdf, image/*">
            <?php if (!empty($siswa['akta'])) { echo "<p>File saat ini: <a href='".$siswa['akta']."' target='_blank'>Lihat</a></p>"; } ?>

            <!-- Upload Surat Keterangan Lulus -->
            <label for="skl">Surat Keterangan Lulus</label>
            <input type="file" name="skl" accept="application/pdf, image/*">
            <?php if (!empty($siswa['skl'])) { echo "<p>File saat ini: <a href='".$siswa['skl']."' target='_blank'>Lihat</a></p>"; } ?>
           
            <label for="nisn">NISN</label>
            <input type="text" name="nisn" value="<?php echo htmlspecialchars($siswa['nisn']); ?>" required>
            <label for="npsn">NPSN Sekolah Asal</label>
            <input type="text" name="npsn" value="<?php echo htmlspecialchars($siswa['npsn']); ?>" required>
            <label for="nama_ayah">Nama Ayah</label>
            <input type="text" name="nama_ayah" value="<?php echo htmlspecialchars($siswa['nama_ayah']); ?>" required>
            <label for="nama_ibu">Nama Ibu</label>
            <input type="text" name="nama_ibu" value="<?php echo htmlspecialchars($siswa['nama_ibu']); ?>" required>
            <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
            <input type="text" name="pekerjaan_ayah" value="<?php echo htmlspecialchars($siswa['pekerjaan_ayah']); ?>" required>
            <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
            <input type="text" name="pekerjaan_ibu" value="<?php echo htmlspecialchars($siswa['pekerjaan_ibu']); ?>" required>
            <label for="gaji_orang_tua">Pendapatan Orang Tua</label>
            <input type="number" name="gaji_orang_tua" value="<?php echo htmlspecialchars($siswa['gaji_orang_tua']); ?>" required>
            <button type="submit">Simpan Perubahan</button>
        </form>
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
