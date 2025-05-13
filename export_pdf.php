<?php
require_once('vendor/autoload.php'); // Pastikan TCPDF sudah di-install

// Koneksi ke database
$conn = new mysqli('localhost', 'ppdb7395_hmppdb', ')i~U8fen8%Zl', 'ppdb7395_hmppdb');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil bulan dan tahun saat ini
$selected_month = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$selected_year = date('Y');

// Query untuk mengambil data pembayaran
$sql = "SELECT * FROM pembayaran_siswa WHERE MONTH(tanggal_bayar) = '$selected_month' AND YEAR(tanggal_bayar) = '$selected_year'";
$result = $conn->query($sql);

// Query untuk laporan keuangan
$sql_total = "SELECT SUM(jumlah_bayar) as total_pemasukan FROM pembayaran_siswa WHERE YEAR(tanggal_bayar) = '$selected_year'";
$result_total = $conn->query($sql_total);
$total_pemasukan = $result_total->fetch_assoc()['total_pemasukan'] ?? 0;

$sql_monthly = "SELECT SUM(jumlah_bayar) as pemasukan_bulanan FROM pembayaran_siswa WHERE MONTH(tanggal_bayar) = '$selected_month' AND YEAR(tanggal_bayar) = '$selected_year'";
$result_monthly = $conn->query($sql_monthly);
$pemasukan_bulanan = $result_monthly->fetch_assoc()['pemasukan_bulanan'] ?? 0;

// Buat PDF baru
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SMK HIJAU MUDA');
$pdf->SetTitle('Laporan Keuangan PPDB');
$pdf->SetMargins(15, 10, 15);
$pdf->AddPage();

// Judul laporan
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, "Laporan Keuangan PPDB - SMK HIJAU MUDA", 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, "Bulan: " . date('F', mktime(0, 0, 0, $selected_month, 10)) . " | Tahun: $selected_year", 0, 1, 'C');
$pdf->Ln(5);

// Tabel Data Pembayaran
$html = '<table border="1" cellspacing="0" cellpadding="5">
            <tr style="background-color:#cccccc;">
                <th width="30px">No</th>
                <th width="150px"><b>Nama</b></th>
                <th width="100px"><b>Jumlah Bayar</b></th>
                <th width="100px"><b>Metode</b></th>
                <th width="100px"><b>Tanggal</b></th>
            </tr>';

$nomor = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td width="30px" align="center">' . $nomor++ . '</td>
                <td width="150px">' . $row['nama'] . '</td>
                <td width="100px">Rp. ' . number_format($row['jumlah_bayar'], 0, ',', '.') . '</td>
                <td width="100px">' . $row['metode_pembayaran'] . '</td>
                <td width="100px">' . $row['tanggal_bayar'] . '</td>
              </tr>';
}
$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Tambahkan laporan total pemasukan
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 7, "Total Pemasukan Tahun $selected_year: Rp. " . number_format($total_pemasukan, 0, ',', '.'), 0, 1);
$pdf->Cell(0, 7, "Pemasukan Bulan " . date('F', mktime(0, 0, 0, $selected_month, 10)) . ": Rp. " . number_format($pemasukan_bulanan, 0, ',', '.'), 0, 1);

// Output PDF
$pdf->Output('Laporan_Keuangan_' . date('Y-m-d') . '.pdf', 'D');
?>
