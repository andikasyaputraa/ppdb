<?php
// Mulai session
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: User ID tidak ditemukan. Silakan login.");
}
$user_id = $_SESSION['user_id'];

// Koneksi ke database
$conn = new mysqli('localhost', 'ppdb7395_smkhm', 'SdfaCOLq6[Tl', 'ppdb7395_smk_hijau_muda');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Cek apakah user sudah melakukan pembayaran sebelumnya
$sql_check = "SELECT * FROM pembayaran_siswa WHERE user_id = '$user_id' LIMIT 1";
$result_check = $conn->query($sql_check);
if ($result_check->num_rows > 0) {
    // Jika data sudah ada, redirect ke halaman lain atau tampilkan pesan
    $_SESSION['message'] = "Anda sudah melakukan pembayaran sebelumnya.";
    $_SESSION['status'] = "info";
    $_SESSION['redirect'] = "pembayaran_siswa.php"; // Ganti dengan halaman yang sesuai
    header("Location: " . $_SESSION['redirect']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data pembayaran dari formulir
    $nama = $_POST['nama'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Mendapatkan tanggal dan waktu saat ini
    $tanggal_bayar = date('Y-m-d');

    // Mengelola file yang diupload
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($bukti_pembayaran);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file benar-benar gambar atau tidak
    $check = getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['message'] = "File bukan gambar.";
        $_SESSION['status'] = "error";
        $uploadOk = 0;
    }

    // Cek upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
            // Simpan data pembayaran
            $sql = "INSERT INTO pembayaran_siswa (user_id, nama, jumlah_bayar, metode_pembayaran, tanggal_bayar, bukti_pembayaran)
                    VALUES ('$user_id','$nama', '$jumlah_bayar', '$metode_pembayaran', '$tanggal_bayar', '$bukti_pembayaran')";

            if ($conn->query($sql) === TRUE) {
                // Update status pembayaran menjadi 'Lunas' pada tabel pendaftar
                $update_status_sql = "UPDATE pembayaran_siswa SET status_pembayaran = 'Lunas' WHERE user_id = '$user_id'";
                
                if ($conn->query($update_status_sql) === TRUE) {
                    $_SESSION['message'] = "Pembayaran berhasil! Terimakasih telah melakukan pembayaran tepat waktu.";
                    $_SESSION['status'] = "success";
                    $_SESSION['redirect'] = "pembayaran_siswa.php"; // Simpan redirect ke session
                } else {
                    $_SESSION['message'] = "Gagal memperbarui status pembayaran.";
                    $_SESSION['status'] = "error";
                }
            } else {
                $_SESSION['message'] = "Terjadi kesalahan: " . $conn->error;
                $_SESSION['status'] = "error";
            }
        } else {
            $_SESSION['message'] = "Terjadi kesalahan saat mengupload file.";
            $_SESSION['status'] = "error";
        }
    }

    // Simpan redirect jika terjadi error
    if (!isset($_SESSION['redirect'])) {
        $_SESSION['redirect'] = "pembayaran_siswa.php";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/pembayaran.css">
    <title>Pembayaran</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
    <div class="container">
        <!-- Informasi Rekening Sekolah -->
        <div class="rekening">
            <strong>Informasi Rekening Sekolah:</strong><br>
            Bank: BNI<br>
            No. Rekening: 123456789<br>
            Atas Nama: SMK Hijau Muda<br>
            <br>
            <strong>Langkah-langkah pembayaran:</strong><br>
            1. Salin No. Rekening sekolah pada m-banking Anda <br>            
            2. Lakukan transfer dan jangan lupa simpan bukti transfer <br>
            3. Isi biodata pada form pembayaran <br>
            4. Masukkan nominal sesuai dengan gelombang pendaftaran <br>
               - ketikkan seperti berikut : 1100000 <br>
               (tanpa Rp. dan tidak perlu pakai titik pemisah nol) <br>
            5. Upload bukti transfer yang telah anda simpan.
        </div>

        <!-- Formulir Pembayaran -->
        <form method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" id="nama" required>

            <label for="jumlah_bayar">Jumlah Pembayaran:</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" required>

            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="Tunai">Tunai</option>
            </select>

            <label for="bukti_pembayaran">Upload Bukti Pembayaran:</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required>

            <button type="submit">Kirim Pembayaran</button>
            <br>
            <br>
            <button><a style="text-decoration: none;color:white;" href="pembayaran_siswa.php">Batal</a></button>
        </form>
    </div>

    <!-- SweetAlert2 -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '" . ($_SESSION['status'] == 'success' ? "Berhasil!" : "Error") . "',
                    text: '" . $_SESSION['message'] . "',
                    icon: '" . $_SESSION['status'] . "' 
                }).then(() => { 
                    window.location.href = '" . $_SESSION['redirect'] . "'; 
                });
            });
        </script>";

        // Hapus session setelah ditampilkan
        unset($_SESSION['message']);
        unset($_SESSION['status']);
        unset($_SESSION['redirect']);
    }
    ?>
</body>
</html>
