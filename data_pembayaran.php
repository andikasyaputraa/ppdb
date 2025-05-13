<?php
// Koneksi ke database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli('localhost', 'ppdb7395_smkhm', 'SdfaCOLq6[Tl', 'ppdb7395_smk_hijau_muda');

// Memeriksa koneksi ke database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil bulan yang dipilih
$selected_month = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$selected_year = date('Y');

// Query untuk mengambil data berdasarkan bulan
$sql = "SELECT * FROM pembayaran_siswa WHERE MONTH(tanggal_bayar) = '$selected_month' AND YEAR(tanggal_bayar) = '$selected_year'";
$result = $conn->query($sql);

// Menambahkan data pembayaran
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_payment'])) {
    $nama = $_POST['nama'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $tanggal_bayar = date('Y-m-d'); // Tanggal saat ini

    // File upload handling
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
    $target_dir = "uploads/";
    $target_file_bukti = $target_dir . basename($bukti_pembayaran);

    if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file_bukti)) {
        // Query untuk memasukkan data pembayaran ke tabel pembayaran
        $sql_add = "INSERT INTO pembayaran_siswa (nama, jumlah_bayar, metode_pembayaran, tanggal_bayar, bukti_pembayaran)
                    VALUES ('$nama', '$jumlah_bayar', '$metode_pembayaran', '$tanggal_bayar', '$bukti_pembayaran')";
        if ($conn->query($sql_add) === TRUE) {
            echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pembayaran berhasil ditambahkan.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'data_pembayaran.php';
                });
            </script>";
        } else {
            echo "Error: " . $sql_add . "<br>" . $conn->error;
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal mengunggah file. Silakan coba lagi.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}

// Menghapus data pembayaran berdasarkan ID yang ada di URL
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Hapus data pembayaran berdasarkan user_id dari parameter URL
    $sql_delete = "DELETE FROM pembayaran_siswa WHERE user_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    
    if ($stmt_delete->execute()) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data pembayaran berhasil dihapus.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'data_pembayaran.php';
            });
        </script>";
    } else {
        echo "Error: " . $stmt_delete->error;
    }
}

// Query untuk laporan pembayaran
$sql_total = "SELECT SUM(jumlah_bayar) as total_pemasukan FROM pembayaran_siswa WHERE YEAR(tanggal_bayar) = '$selected_year'";
$result_total = $conn->query($sql_total);
$total_pemasukan = $result_total->fetch_assoc()['total_pemasukan'] ?? 0;

$sql_monthly = "SELECT SUM(jumlah_bayar) as pemasukan_bulanan FROM pembayaran_siswa WHERE MONTH(tanggal_bayar) = '$selected_month' AND YEAR(tanggal_bayar) = '$selected_year'";
$result_monthly = $conn->query($sql_monthly);
$pemasukan_bulanan = $result_monthly->fetch_assoc()['pemasukan_bulanan'] ?? 0;

// Export ke Excel
if (isset($_POST['export_to_excel'])) {
    // Include PhpSpreadsheet library
    require 'vendor/autoload.php';
    
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set header Excel
    $sheet->setCellValue('A1', 'Nama');
    $sheet->setCellValue('B1', 'Jumlah Bayar');
    $sheet->setCellValue('C1', 'Metode Pembayaran');
    $sheet->setCellValue('D1', 'Tanggal Bayar');
    $sheet->setCellValue('E1', 'Pemasukan bulanan');
    
    // Menambahkan data pembayaran ke Excel
    $row_num = 2; // Baris pertama data dimulai dari baris 2
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row_num, $row['nama']);
            $sheet->setCellValue('B' . $row_num, $row['jumlah_bayar']);
            $sheet->setCellValue('C' . $row_num, $row['metode_pembayaran']);
            $sheet->setCellValue('D' . $row_num, $row['tanggal_bayar']);
            $sheet->setCellValue('E' . $row_num, $pemasukan_bulanan); // Keuntungan per bulan
            $row_num++;
        }
    }
    
    // Set header untuk mendownload file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="data_pembayaran_siswa_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran Siswa</title>
    <link rel="stylesheet" href="css/data_pembayaran.css">

</head>

<style>
    /* Container filter dan tombol export */
.filter-export {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin: 10px;
}

.form-bulan select {
    padding: 10px;
    width: 350px ;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* Export group styling */
.export-group {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* Responsive untuk layar kecil */
@media screen and (max-width: 768px) {
    @media screen and (max-width: 768px) {
    form {
        width: 100%;
    }

    form#bulan, form select {
        width: 50%;
        margin-left: 1%;
    }

    .export-container {
        flex-direction: column;
        align-items: center;
        margin: 10px 0;
        margin-left: 0 !important;
        gap: 10px;
    }

    .export-container form {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .export-container button {
        width: 100%;
    }

    label[for="bulan"] {
        margin-left: 1%;
        text-align: left;
    }
}
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
        <!-- Hanya satu hamburger menu -->
        <div class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </nav>
</header>


<br>
<br>

<!-- Dropdown filter bulan -->
<div class="filter-export">
    <!-- Dropdown filter bulan -->
    <form method="GET" class="form-bulan">
        <label for="bulan">Pilih Bulan:</label>
        <select name="bulan" id="bulan" onchange="this.form.submit()">
            <?php for ($i = 1; $i <= 12; $i++) {
                $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                $selected = ($month == $selected_month) ? "selected" : "";
                echo "<option value='$month' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
            } ?>
        </select>
    </form>

    <!-- Tombol Export -->
    <div class="export-container" style="display: flex; gap: 10px; margin-left:40%">
    <form method="POST">
        <button type="submit" name="export_to_excel">Export ke Excel</button>
    </form>

    <form action="export_pdf.php" method="GET">
        <input type="hidden" name="bulan" value="<?= $selected_month; ?>">
        <button type="submit">Export ke PDF</button>
    </form>
</div>

<br>
<!-- Laporan Pembayaran -->
<div class="laporan">
    <h3>Laporan Pembayaran</h3>
    <table>
        <tr>
            <th>Total Pemasukan PPDB Tahun <?= $selected_year; ?>:</th>
            <td><b>Rp. <?= number_format($total_pemasukan, 0, ',', '.'); ?></b></td>
        </tr>
        <tr>
            <th>Pemasukan Bulan <?= date('F', mktime(0, 0, 0, $selected_month, 10)); ?>:</th>
            <td><b>Rp. <?= number_format($pemasukan_bulanan, 0, ',', '.'); ?></b></td>
        </tr>
    </table>
</div>

<!-- Tabel pembayaran -->
<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Jumlah Bayar</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal Bayar</th>
            <th>Bukti Pembayaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td>Rp. " . number_format($row['jumlah_bayar'], 0, ',', '.') . "</td>";
            echo "<td>" . htmlspecialchars($row['metode_pembayaran']) . "</td>";
            echo "<td>" . htmlspecialchars($row['tanggal_bayar']) . "</td>";
            echo "<td><a href='uploads/" . htmlspecialchars($row['bukti_pembayaran']) . "' target='_blank'>Lihat Bukti</a></td>";
            echo "<td><a href='data_pembayaran.php?delete=" . $row['user_id'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Belum ada data pembayaran</td></tr>";
    }
    ?>
    </tbody>
</table>
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
<?php $conn->close(); ?>
