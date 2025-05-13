<?php
ob_start(); 
session_start(); 

// Load library PhpSpreadsheet
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Koneksi ke database
include 'includes/db.php';

$admin_id = $_SESSION['user_id']; // ini yang harus kamu tambahkan


// Mendapatkan semua data pendaftar
$sql = "SELECT pendaftar.*, pembayaran_siswa.status_pembayaran 
        FROM pendaftar 
        LEFT JOIN pembayaran_siswa ON pendaftar.user_id = pembayaran_siswa.user_id";
$result = $conn->query($sql);

// Cek apakah kueri berhasil
if (!$result) {
    die("Error: " . $conn->error);
}

// Fungsi untuk mengekspor data ke Excel
function exportToExcel($data) {
    ob_start();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set judul kolom
    $sheet->setCellValue('A1', 'Gelombang');
    $sheet->setCellValue('B1', 'rekomendasi');
    $sheet->setCellValue('C1', 'email');
    $sheet->setCellValue('D1', 'telp');
    $sheet->setCellValue('E1', 'nik');
    $sheet->setCellValue('F1', 'Nama Lengkap');
    $sheet->setCellValue('G1', 'Tempat Lahir');
    $sheet->setCellValue('H1', 'Tanggal Lahir');
    $sheet->setCellValue('I1', 'Jenis Kelamin');
    $sheet->setCellValue('J1', 'Alamat');
    $sheet->setCellValue('K1', 'Agama');
    $sheet->setCellValue('L1', 'Anak Ke');
    $sheet->setCellValue('N1', 'Jumlah Saudara');
    $sheet->setCellValue('M1', 'Status Keluarga');
    $sheet->setCellValue('O1', 'Asal Sekolah');
    $sheet->setCellValue('P1', 'Alamat Sekolah');
    $sheet->setCellValue('Q1', 'NPSN');
    $sheet->setCellValue('R1', 'Jurusan');
    $sheet->setCellValue('S1', 'NISN');
    $sheet->setCellValue('T1', 'Keluhan');
    $sheet->setCellValue('U1', 'Nama Ayah');
    $sheet->setCellValue('V1', 'Pekerjaan Ayah');
    $sheet->setCellValue('W1', 'Nama Ibu');
    $sheet->setCellValue('X1', 'Pekerjaan Ibu');
    $sheet->setCellValue('Y1', 'Alamat Orang Tua');
    $sheet->setCellValue('Z1', 'Gaji Orang Tua');
    $sheet->setCellValue('AA1', 'Status Pendaftaran');
    $sheet->setCellValue('AB1', 'Status pembayaran');
    $sheet->setCellValue('AC1', 'Waktu Pendaftaran');

    
    // Mengisi data pendaftar dari database
    $rowNumber = 2; // Mulai dari baris ke-2 karena baris pertama adalah judul kolom
    while ($row = $data->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['gelombang']);
        $sheet->setCellValue('B' . $rowNumber, $row['rekomendasi']);
        $sheet->setCellValue('C' . $rowNumber, $row['email']);
        $sheet->setCellValue('D' . $rowNumber, $row['telp']);
        $sheet->setCellValue('E' . $rowNumber, $row['nik']);
        $sheet->setCellValue('F' . $rowNumber, $row['nama']);
        $sheet->setCellValue('G' . $rowNumber, $row['tempat_lahir']);
        $sheet->setCellValue('H' . $rowNumber, $row['tanggal_lahir']);
        $sheet->setCellValue('I' . $rowNumber, $row['jenis_kelamin']);
        $sheet->setCellValue('J' . $rowNumber, $row['alamat']);
        $sheet->setCellValue('K' . $rowNumber, $row['agama']);
        $sheet->setCellValue('L' . $rowNumber, $row['anak_ke']);
        $sheet->setCellValue('M' . $rowNumber, $row['jumlah_saudara']);
        $sheet->setCellValue('N' . $rowNumber, $row['status_keluarga']);
        $sheet->setCellValue('O' . $rowNumber, $row['asal_sekolah']);
        $sheet->setCellValue('P' . $rowNumber, $row['Alamat_Sekolah']);
        $sheet->setCellValue('Q' . $rowNumber, $row['npsn']);
        $sheet->setCellValue('R' . $rowNumber, $row['jurusan']);
        $sheet->setCellValue('S' . $rowNumber, $row['nisn']);
        $sheet->setCellValue('T' . $rowNumber, $row['keluhan']);
        $sheet->setCellValue('U' . $rowNumber, $row['nama_ayah']);
        $sheet->setCellValue('V' . $rowNumber, $row['pekerjaan_ayah']);
        $sheet->setCellValue('W' . $rowNumber, $row['nama_ibu']);
        $sheet->setCellValue('X' . $rowNumber, $row['pekerjaan_ibu']);
        $sheet->setCellValue('Y' . $rowNumber, $row['alamat_orang_tua']);
        $sheet->setCellValue('Z' . $rowNumber, $row['gaji_orang_tua']);
        $sheet->setCellValue('AA' . $rowNumber, $row['status_pendaftaran']);
        $sheet->setCellValue('AB' . $rowNumber, $row['status_pembayaran']);
        $sheet->setCellValue('AC' . $rowNumber, $row['timestamp']);
        $rowNumber++;
    }

   $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="data calon siswa - PPDB 2025.xlsx"');
    header('Cache-Control: max-age=0');

    ob_end_clean();
    $writer->save('php://output');
    exit();
}

// Mengecek apakah tombol ekspor ditekan
if (isset($_GET['export'])) {
    exportToExcel($result);
}

// Handle "Terima" dan "Tolak"
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Validasi ID harus angka
    if (!is_numeric($user_id)) {
        echo json_encode(["success" => false, "message" => "ID tidak valid"]);
        exit;
    }

   // Tentukan status berdasarkan aksi
if ($action == 'terima') {
    $status_pendaftaran = 'Diterima';
    $subject = "Selamat! Pendaftaran Anda Diterima - PPDB SMK HIJAU MUDA TA 2025/2026";
    $message = "
    <h2>Selamat, {$email}!</h2>
    <p>Pendaftaran Anda telah diterima. Kami sangat senang menyambut Anda di SMK Hijau Muda!</p>
    <p>Segera login ke dan akses pendaftaran anda untuk memperoleh informasi lebih lanjut dan lakukan cetak bukti fisik pendaftaran anda.</p>
    <p>Untuk mengakses sistem, klik tombol di bawah ini:</p>
    <a href='https://ppdb.site/smkhijaumuda/login.php' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; display: inline-block; border-radius: 5px; text-decoration: none;'>Masuk ke Sistem</a>
    <p>Pelaksanaan daftar ulang pada tanggal 12 Juli 2025 pukul 08.00 - 15.00 WIB</p>
    <p>Jika Anda mengalami kesulitan, silakan hubungi kami.</p>
    <p>Sampai jumpa di kampus Hijau</p>
    <p>Salam hormat,</p>
    <p>Tim PPDB SMK Hijau Muda</p>
    ";
} elseif ($action == 'tolak') {
    $status_pendaftaran = 'Ditolak';
    $subject = "Pengumuman PPBD SMK HIJAU MUDA TA 2025/2026";
    $message = "
    <h2>Mohon Maaf, {$email}</h2>
    <p>Sayangnya, pendaftaran Anda untuk PPDB SMK Hijau Muda tahun ajaran 2025/2026 telah ditolak.</p>
    <p>Kami menghargai usaha Anda dan berharap Anda tidak menyerah. Terima kasih telah mempercayai kami.</p>
    <p>Semoga Anda sukses dalam upaya selanjutnya. Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.</p>
    <p>Salam hormat,</p>
    <p>Tim PPDB SMK Hijau Muda</p>
    ";
} else {
    echo "<script>
        Swal.fire('Error!', 'Aksi tidak valid', 'error');
    </script>";
    exit;
}

    
    // Ambil email berdasarkan user_id
    $query_email = "SELECT email FROM pendaftar WHERE user_id = ?";
    $stmt_email = $conn->prepare($query_email);
    $stmt_email->bind_param("i", $user_id);
    $stmt_email->execute();
    $stmt_email->bind_result($email);
    $stmt_email->fetch();
    $stmt_email->close();

    if (!$email) {
        echo "<script>
            Swal.fire('Error!', 'Email tidak ditemukan', 'error');
        </script>";
        exit;
    }
    
    // Sesuaikan pesan dengan nama pengguna
    $message = "Halo {$email},<br><br>" . $message;
    
    $query = "UPDATE pendaftar SET status_pendaftaran = ?, admin_id = ?   WHERE user_id = ?";
    $stmt = $conn->prepare($query);
     $stmt->bind_param("sii", $status_pendaftaran, $admin_id, $user_id);
     
     

    if ($stmt->execute()) {
        // Kirim email menggunakan PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Ganti jika pakai SMTP hosting lain
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ppdbsmkhijaumuda@gmail.com'; // Ganti
            $mail->Password   = 'ftnn tohn cbgi ejgh';    // Ganti dengan app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email pengirim dan penerima
            $mail->setFrom('ppdbsmkhijaumuda@gmail.com', 'PANITIA PPDB SMK Hijau Muda');
            $mail->addAddress($email);

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "<h3>{$subject}</h3><p>{$message}</p>";
            $mail->AltBody = $message;

            $mail->send();

            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Status berhasil diperbarui & email dikirim!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'data_pendaftar_admin.php';
                });
            </script>";
        } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Status diperbarui',
                    text: 'Email gagal dikirim: " . $mail->ErrorInfo . "',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'data_pendaftar_admin.php';
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat memperbarui status',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
// Ambil nilai pencarian dan filter gelombang dari URL
$searchNama = isset($_GET['nama']) ? mysqli_real_escape_string($conn, urldecode(trim($_GET['nama']))) : '';
$gelombang = isset($_GET['gelombang']) ? trim($_GET['gelombang']) : '';

// Debugging: Cek apakah parameter diterima
// echo "Nama yang dicari: " . htmlspecialchars($searchNama) . "<br>";
// echo "Gelombang: " . htmlspecialchars($gelombang) . "<br>";

// Query dasar dengan join tabel pendaftar dan pembayaran_siswa
$query = "
    SELECT pendaftar.*, pembayaran_siswa.status_pembayaran
    FROM pendaftar
    LEFT JOIN pembayaran_siswa ON pendaftar.user_id = pembayaran_siswa.user_id
    WHERE 1=1"; // WHERE 1=1 agar bisa ditambahkan kondisi lain

// Tambahkan filter pencarian nama
if (!empty($searchNama)) {
    $query .= " AND LOWER(TRIM(pendaftar.nama)) LIKE LOWER(TRIM('%" . mysqli_real_escape_string($conn, $searchNama) . "%'))";
}

// Tambahkan filter gelombang
if (!empty($gelombang)) {
    $query .= " AND TRIM(pendaftar.gelombang) = TRIM('$gelombang')";
}

// Tambahkan ORDER BY di akhir query
$query .= " ORDER BY pendaftar.timestamp DESC";

// Debugging: Tampilkan query yang dihasilkan
// echo "<pre>$query</pre>";

// Eksekusi query
$result = mysqli_query($conn, $query) or die("Error: " . mysqli_error($conn));

// Debugging: Cek apakah hasil ditemukan
// if (mysqli_num_rows($result) == 0) {
//     echo "Data tidak ditemukan!";
// } else {
//     echo "Jumlah hasil ditemukan: " . mysqli_num_rows($result);
// }
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar</title>
    <link rel="stylesheet" href="css/data_pendaftar.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
 
<style>
    #filterForm {
    display: inline-block; /* Supaya form sejajar */
    margin-left: 10px; /* Beri jarak dari tombol Export */
}

.export-button {
    display: inline-block; /* Supaya tetap sejajar */
    padding: 10px 16px;
    background-color:rgb(29, 92, 65);
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

#filterForm input,
#filterForm select,
#filterForm button {
    padding: 10px;
    margin-right: 3px;
    border-radius: 4px;
}

</style>

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
         <div class="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </nav>
</header>

<main>
    <h2>Data Pendaftar</h2>
    <a class="export-button diterima" href="?export">Export Excel</a>

   <!-- Form Filter -->
   <form id="filterForm" method="GET" action="">
    <input type="text" name="nama" id="nama" placeholder="Cari Nama..." 
        value="<?= isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : '' ?>" 
        style="padding: 10px; width: 200px;">

    <select name="gelombang" id="gelombang">
        <option value="">Semua Gelombang</option>
        <option value="1" <?= (isset($_GET['gelombang']) && $_GET['gelombang'] == '1') ? 'selected' : '' ?>>Gelombang 1</option>
        <option value="2" <?= (isset($_GET['gelombang']) && $_GET['gelombang'] == '2') ? 'selected' : '' ?>>Gelombang 2</option>
        <option value="3" <?= (isset($_GET['gelombang']) && $_GET['gelombang'] == '3') ? 'selected' : '' ?>>Gelombang 3</option>
    </select>

    <button type="submit" class="button export">Filter</button>
</form>


    <table>
        <thead>
            <tr>
            <th>Gelombang</th>
            <th>Nama Lengkap</th>
            <th>Rekomendaasi</th>
            <!-- <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Agama</th>
            <th>Anak Ke</th>
            <th>Jumlah Saudara</th>
            <th>Status Keluarga</th>
            <th>Asal Sekolah</th>
            <th>Alamat Sekolah</th>
            <th>NPSN</th>
            <th>Jurusan</th>
            <th>NISN</th>
            <th>Keluhan</th>
            <th>Nama Ayah</th>
            <th>Pekerjaan ayah</th>
            <th>Nama Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>Alamat Orang Tua</th>
            <th>Gaji Orang Tua</th> -->
            <th>Status Pendaftaran</th>
            <th>Status Pembayaran</th>
            <th>Waktu Pendaftaran</th>
            <th>Action</th>
            <th>Detail Siswa</th>
            
            </tr>
        </thead>
        <tbody id="data_table" >
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
            <td><?= $row['gelombang']; ?></td>
            <td>
                <a href="siswa_detail.php?id=<?= $row['user_id']; ?>" style="text-decoration: none; color: blue;">
                    <?= $row['nama']; ?>
                </a>
            </td>

                    <td><?= $row['rekomendasi']; ?></td>
                    
                    <!-- <td><?= $row['tempat_lahir']; ?></td>
                    <td><?= $row['tanggal_lahir']; ?></td>
                    <td><?= $row['jenis_kelamin']; ?></td>
                    <td><?= $row['alamat']; ?></td>
                    <td><?= $row['agama']; ?></td>
                    <td><?= $row['anak_ke']; ?></td>
                    <td><?= $row['jumlah_saudara']; ?></td>
                    <td><?= $row['status_keluarga']; ?></td>
                    <td><?= $row['asal_sekolah']; ?></td>
                    <td><?= $row['Alamat_Sekolah']; ?></td>
                    <td><?= $row['npsn']; ?></td>
                    <td><?= $row['jurusan']; ?></td>
                    <td><?= $row['nisn']; ?></td>
                    <td><?= $row['keluhan']; ?></td>
                    <td><?= $row['nama_ayah']; ?></td>
                    <td><?= $row['pekerjaan_ayah']; ?></td>
                    <td><?= $row['nama_ibu']; ?></td>
                    <td><?= $row['pekerjaan_ibu']; ?></td>
                    <td><?= $row['alamat_orang_tua']; ?></td>
                    <td><?= $row['gaji_orang_tua']; ?></td> -->
                    <td><?= $row['status_pendaftaran']; ?></td>
                    <td><?= $row['status_pembayaran']; ?></td> 
                    <td><?= $row['timestamp']; ?></td>
                <td>
                <form id="form_<?php echo $row['user_id']; ?>" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                    <button type="button" class="export-button diterima"
                        style="background-color:rgb(40, 114, 167); color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 5px;"
                        onclick="confirmAction('<?php echo $row['user_id']; ?>', 'terima')">Terima</button>

                    <button type="button" class="export-button ditolak"
                        style="background-color: #dc3545; color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 5px;"
                        onclick="confirmAction('<?php echo $row['user_id']; ?>', 'tolak')">Tolak</button>
                </form>
                </td>
                </td>
                <td>
                    <a style="text-decoration:none;" href="siswa_detail.php?id=<?= $row['user_id']; ?>" class="btn">
                    Lihat disini
                    </a>

                </td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
</main>

<!-- Tabel Hasil -->
<table>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['gelombang']) ?></td>
                        <td>
                            <a href="siswa_detail.php?id=<?= $row['user_id']; ?>" style="text-decoration: none; color: blue;">
                                <?= htmlspecialchars($row['nama']); ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($row['rekomendasi']); ?></td>
                        <td><?= htmlspecialchars($row['status_pendaftaran']); ?></td>
                        <td><?= htmlspecialchars($row['status_pembayaran']); ?></td>
                        <td><?= htmlspecialchars($row['timestamp']); ?></td>
                         <td>
                        <form id="form_<?php echo $row['user_id']; ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                            <button type="button" class="export-button diterima"
                                style="background-color:rgb(40, 114, 167); color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 5px;"
                                onclick="confirmAction('<?php echo $row['user_id']; ?>', 'terima')">Terima</button>

                            <button type="button" class="export-button ditolak"
                                style="background-color: #dc3545; color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 5px;"
                                onclick="confirmAction('<?php echo $row['user_id']; ?>', 'tolak')">Tolak</button>
                        </form>
                        </td>
                         <td>
                        <a href="siswa_detail.php?id=<?= $row['user_id']; ?>" class="btn">
                            Lihat
                        </a>

                        </td>
                        <!--<td>-->
                        <!--    <form method="POST" action="send_email.php">-->
                        <!--        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">-->
                        <!--        <button type="submit" name="kirim_email" class="export-button kirim-email" -->
                        <!--            style="background-color:rgb(23, 91, 70); color: white; border: none; padding: 8px 16px; cursor: pointer; border-radius: 5px;">-->
                        <!--            Kirim Email-->
                        <!--        </button>-->
                        <!--    </form>-->
                        <!--</td>-->
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    function confirmAction(user_id, action) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: action === 'terima' ? 'Terima pendaftar ini?' : 'Tolak pendaftar ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat form dinamis untuk submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = ''; 

                // Tambahkan input hidden untuk mengirim user_id dan action
                const inputUserId = document.createElement('input');
                inputUserId.type = 'hidden';
                inputUserId.name = 'user_id';
                inputUserId.value = user_id;

                const inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'action';
                inputAction.value = action;

                // Tambahkan input ke dalam form
                form.appendChild(inputUserId);
                form.appendChild(inputAction);

                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
     // hamburger
      document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");

    hamburger.addEventListener("click", function () {
        navMenu.classList.toggle("active");
    });
});
</script>


</body>
</html>
