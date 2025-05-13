<?php
// Koneksi ke database
include 'includes/db.php';

// Memanggil autoload Composer (jika menggunakan Composer)
require 'vendor/autoload.php'; // Sesuaikan dengan path Anda jika manual

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Fungsi untuk mengekspor data ke Excel
function exportToExcel($data) {
    // Membuat instance Spreadsheet baru
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Menambahkan header kolom
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
    $sheet->setCellValue('M1', 'Jumlah Saudara');
    $sheet->setCellValue('N1', 'Status Keluarga');
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
    $sheet->setCellValue('AB', 'Status pembayaran');
    $sheet->setCellValue('AC1', 'Waktu Pendaftaran');



    // Menambahkan data ke baris berikutnya
    $rowNumber = 2;
    while ($row = $data->fetch_assoc()) {
     $sheet->setCellValue('A' . $rowNumber, $row['gelombang']);
        $sheet->setCellValue('B' . $rowNumber, $row['rekomendasi']);
        $sheet->setCellValue('C' . $rowNumber, $row['email']);
        $sheet->setCellValue('D' . $rowNumber, $row['telp']);
        $sheet->setCellValue('E' . $rowNumber, $row['telp']);
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

    // Mengatur header untuk mengunduh file Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="data calon siswa - PPDB 2025.xlsx"');
    header('Cache-Control: max-age=0');

    // Menulis file Excel ke output
    $writer = new xlsx($spreadsheet);
    $writer->save('data calon siswa - PPDB 2025.xlsx');
    // $writer->save('php://output');
}

// Query untuk mendapatkan data pendaftar
$sql = "SELECT * FROM pendaftar"; // Sesuaikan dengan nama tabel Anda
$result = $conn->query($sql);

// Mengecek apakah tombol ekspor ditekan
if (isset($_GET['export'])) {
    if ($result->num_rows > 0) {
        exportToExcel($result);
    } else {
        echo "Tidak ada data untuk diekspor.";
    }
    exit();
}
?>
