<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Pendaftaran</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/submit.css">
</head>
<body>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/db.php';

// Ambil data dari form
$user_id = $_POST['user_id'] ?? null;
$gelombang = $_POST['gelombang'] ?? '';
$rekomendasi = $_POST['rekomendasi'] ?? '';
$nama = $_POST['nama'] ?? '';
$email = $_POST['email'] ?? ''; 
$telp = $_POST['telp'] ?? ''; 
$nik = $_POST['nik'] ?? '';
$tempat_lahir = $_POST['tempat_lahir'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$agama = $_POST['agama'] ?? '';
$anak_ke = $_POST['anak_ke'] ?? 0;
$jumlah_saudara = $_POST['jumlah_saudara'] ?? 0;
$status_keluarga = $_POST['status_keluarga'] ?? '';
$asal_sekolah = $_POST['asal_sekolah'] ?? '';
$Alamat_Sekolah = $_POST['Alamat_Sekolah'] ?? '';
$npsn = $_POST['npsn'] ?? '';
$jurusan = $_POST['jurusan'] ?? '';
$nisn = $_POST['nisn'] ?? '';
$keluhan = $_POST['keluhan'] ?? '';
$nama_ayah = $_POST['nama_ayah'] ?? '';
$nama_ibu = $_POST['nama_ibu'] ?? '';
$pekerjaan_ayah = $_POST['pekerjaan_ayah'] ?? '';
$pekerjaan_ibu = $_POST['pekerjaan_ibu'] ?? '';
$gaji_orang_tua = $_POST['gaji_orang_tua'] ?? '';
$alamat_orang_tua = $_POST['alamat_orang_tua'] ?? '';
$status_pendaftaran = 'Diproses';
$status_pembayaran = 'Diproses';

// Validasi jika field penting kosong
if (empty($nama) || empty($nik) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($jenis_kelamin) || empty($alamat) || empty($email) || empty($telp)) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pastikan semua data yang diperlukan telah diisi.'
            }).then(() => {
                window.history.back();
            });
          </script>";
    exit;
}

// Cek apakah NIK sudah ada di database
$cekNikSql = "SELECT COUNT(*) AS total FROM pendaftar WHERE nik = ?";
$stmtCekNik = $conn->prepare($cekNikSql);
$stmtCekNik->bind_param("s", $nik);
$stmtCekNik->execute();
$resultCekNik = $stmtCekNik->get_result();
$dataCekNik = $resultCekNik->fetch_assoc();

if ($dataCekNik['total'] > 0) {
    echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Whopps!',
                text: 'Mohon maaf, Anda tidak dapat mendaftar lebih dari 1 kali.'
            }).then(() => {
                window.history.back();
            });
          </script>";
    exit;
}

$stmtCekNik->close();

// //Proses Upload File
// $uploadDir = "uploads/";
// $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
// $maxSize = 2 * 1024 * 1024; // 2MB

// proses upload tidak dengan spasi
// function uploadFile($fileInput, $uploadDir, $allowedTypes, $maxSize) {
//     if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]['error'] !== UPLOAD_ERR_OK) {
//         return null;
//     }

//     $fileName = basename($_FILES[$fileInput]['name']);
//     $fileTmp = $_FILES[$fileInput]['tmp_name'];
//     $fileSize = $_FILES[$fileInput]['size'];
//     $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

//     if (!in_array($fileExt, $allowedTypes)) {
//         return null;
//     }

//     if ($fileSize > $maxSize) {
//         return null;
//     }

//     $newFileName = uniqid() . "." . $fileExt;
//     $destination = $uploadDir . $newFileName;

//     if (move_uploaded_file($fileTmp, $destination)) {
//         return $newFileName;
//     }

//     return null;
// }

// Folder penyimpanan file
$uploadDir = "uploads/";
$allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
$maxSize = 2 * 1024 * 1024; // 2MB

// Fungsi upload yang disamakan
function uploadFile($file, $existing_file, $uploadDir, $allowedTypes, $maxSize) {
    if (!empty($file["name"]) && $file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file["name"]);
        $fileName = preg_replace('/\s+/', '_', $fileName); // Ganti spasi jadi _
        $fileTmp = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validasi ekstensi dan ukuran
        if (in_array($fileExt, $allowedTypes) && $fileSize <= $maxSize) {
            $newFileName = uniqid() . "_" . $fileName;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $destination)) {
                return $newFileName;
            }
        }
    }

    // Jika gagal upload, kembalikan file lama (misalnya dari database)
    return $existing_file;
}

// Contoh penggunaan
$foto = uploadFile($_FILES['foto'], null, $uploadDir, $allowedTypes, $maxSize);
$kk   = uploadFile($_FILES['kk'], null, $uploadDir, $allowedTypes, $maxSize);
$akta = uploadFile($_FILES['akta'], null, $uploadDir, $allowedTypes, $maxSize);
$skl  = uploadFile($_FILES['skl'], null, $uploadDir, $allowedTypes, $maxSize);



// Query untuk memasukkan data ke database
$sql = "INSERT INTO pendaftar (
    gelombang, rekomendasi, nama, email, telp, nik, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, agama, anak_ke, jumlah_saudara, 
    status_keluarga, asal_sekolah, Alamat_Sekolah, npsn, jurusan, nisn, keluhan, nama_ayah, nama_ibu, alamat_orang_tua, 
    pekerjaan_ayah, pekerjaan_ibu, gaji_orang_tua, status_pendaftaran, status_pembayaran, foto, kk, akta, skl, user_id
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Kesalahan dalam query SQL: {$conn->error}'
            });
          </script>");
}

$stmt->bind_param(
    "ssssssssssssisssssssssssssssssssi", // 34 parameter sesuai jumlah kolom
    $gelombang, $rekomendasi, $nama, $email, $telp, $nik, $tempat_lahir, 
    $tanggal_lahir, $jenis_kelamin, $alamat, $agama, $anak_ke, 
    $jumlah_saudara, $status_keluarga, $asal_sekolah, $Alamat_Sekolah, 
    $npsn, $jurusan, $nisn, $keluhan, $nama_ayah, $nama_ibu, 
    $alamat_orang_tua, $pekerjaan_ayah, $pekerjaan_ibu, $gaji_orang_tua, 
    $status_pendaftaran, $status_pembayaran, $foto, $kk, $akta, $skl, 
    $user_id
);


if ($stmt->execute()) {
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berhasil!',
                text: 'Jangan lupa selesaikan pembayaran Anda!'
            }).then(() => {
                window.location.href = 'pendaftaran_siswa.php';
            });
          </script>";
} else {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan: {$stmt->error}'
            });
          </script>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>
