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
    SELECT pesanan.id, produk.nama_produk, pelanggan.nama AS nama_pelanggan, pesanan.jumlah, pesanan.total_harga, pesanan.tanggal_pesanan, pesanan.status 
    FROM pesanan 
    INNER JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
    INNER JOIN produk ON pesanan.produk_id = produk.id
    WHERE MONTH(pesanan.tanggal_pesanan) = '$bulan'
    AND pesanan.status IN ('masuk', 'diproses', 'dikirim','selesai')
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

// Generate HTML content
$html = '<h2>Laporan Pendapatan Bulan ' . $nama_bulan_dipilih . '</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5">';
$html .= '<thead><tr><th>No</th><th>Nama Pelanggan</th><th>Nama Produk</th><th>Jumlah</th><th>Total Harga</th><th>Tanggal Pesanan</th><th>Status</th></tr></thead><tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $status = '';
    if ($row['status'] == 'masuk') {
        $status = 'Masuk';
    } elseif ($row['status'] == 'diproses') {
        $status = 'Diproses';
    } elseif ($row['status'] == 'dikirim') {
        $status = 'Dikirim';
    } elseif ($row['status'] == 'selesai') {
        $status = 'selesai';
    }

    $html .= '<tr>';
    $html .= '<td>' . $no . '</td>';
    $html .= '<td>' . $row['nama_pelanggan'] . '</td>';
    $html .= '<td>' . $row['nama_produk'] . '</td>';
    $html .= '<td>' . $row['jumlah'] . '</td>';
    $html .= '<td>' . $row['total_harga'] . '</td>';
    $html .= '<td>' . $row['tanggal_pesanan'] . '</td>';
    $html .= '<td>' . $status . '</td>';
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
$dompdf->stream("Laporan Pendapatan Bulan {$nama_bulan_dipilih}.pdf", array("Attachment" => 1));
exit;
