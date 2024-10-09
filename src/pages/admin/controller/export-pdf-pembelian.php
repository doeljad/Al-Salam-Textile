<?php
require __DIR__ . '/../../../assets/vendors/autoload.php';
include('../../../config/koneksi.php');

use Dompdf\Dompdf;
use Dompdf\Options;

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
    SELECT dp.id AS detil_id, pb.id AS pembelian_id, pb.supplier_id, dp.produk_id, dp.jumlah, dp.harga_satuan, pb.tanggal_pembelian, pb.total_harga, pr.nama_produk 
    FROM detil_pembelian dp
    JOIN pembelian pb ON dp.pembelian_id = pb.id
    JOIN produk pr ON dp.produk_id = pr.id
    WHERE MONTH(pb.tanggal_pembelian) = '$bulan'
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

// Generate HTML content
$html = '<h2>Laporan Pembelian Bulan ' . $nama_bulan_dipilih . '</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5">';
$html .= '<thead><tr><th>No</th><th>Nama Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Total Harga</th><th>Tanggal Pembelian</th></tr></thead><tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>';
    $html .= '<td>' . $no . '</td>';
    $html .= '<td>' . $row['nama_produk'] . '</td>';
    $html .= '<td>' . $row['jumlah'] . '</td>';
    $html .= '<td>' . $row['harga_satuan'] . '</td>';
    $html .= '<td>' . $row['total_harga'] . '</td>';
    $html .= '<td>' . $row['tanggal_pembelian'] . '</td>';
    $html .= '</tr>';
    $no++;
}

$html .= '</tbody></table>';

$conn->close();

// Initialize Dompdf and generate PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Stream the PDF to the browser
$dompdf->stream("Laporan Pembelian Bulan {$nama_bulan_dipilih}.pdf", array("Attachment" => 1));
exit;
