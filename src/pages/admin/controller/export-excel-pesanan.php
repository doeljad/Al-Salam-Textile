<?php
require __DIR__ . '/../../../assets/vendors/autoload.php';
include('../../../config/koneksi.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Mulai output buffering
ob_start();

// Array untuk mengubah nomor bulan menjadi nama bulan dalam bahasa Indonesia
$nama_bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
];

// Retrieve month from the URL
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$nama_bulan_dipilih = isset($nama_bulan[$bulan]) ? $nama_bulan[$bulan] : '';

// Query to fetch data based on the month
$query = "
    SELECT dp.id AS detil_id, p.id AS pesanan_id, p.pelanggan_id, dp.produk_id, dp.jumlah, dp.harga_satuan, p.tanggal_pesanan, p.status, p.total_harga, pr.nama_produk 
    FROM detil_pesanan dp
    JOIN pesanan p ON dp.pesanan_id = p.id
    JOIN produk pr ON dp.produk_id = pr.id
    WHERE MONTH(p.tanggal_pesanan) = '$bulan'
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Laporan Pesanan Bulan ' . $nama_bulan_dipilih);

// Set headers
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama Produk');
$sheet->setCellValue('C1', 'Jumlah');
$sheet->setCellValue('D1', 'Harga Satuan');
$sheet->setCellValue('E1', 'Total Harga');
$sheet->setCellValue('F1', 'Tanggal Pesanan');
$sheet->setCellValue('G1', 'Status');

// Populate data
$rowNumber = 2;
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowNumber, $no);
    $sheet->setCellValue('B' . $rowNumber, $row['nama_produk']);
    $sheet->setCellValue('C' . $rowNumber, $row['jumlah']);
    $sheet->setCellValue('D' . $rowNumber, $row['harga_satuan']);
    $sheet->setCellValue('E' . $rowNumber, $row['total_harga']);
    $sheet->setCellValue('F' . $rowNumber, $row['tanggal_pesanan']);
    $sheet->setCellValue('G' . $rowNumber, $row['status']);
    $rowNumber++;
    $no++;
}

$conn->close();

// Create a Writer and save the file to output
$writer = new Xlsx($spreadsheet);

// Bersihkan buffer output sebelum mengirim header
ob_end_clean();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan Pesanan Bulan ' . $nama_bulan_dipilih . '.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
