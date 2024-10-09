<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv_alsalam";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Periksa apakah koneksi berhasil
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}
// Query untuk mengambil data penjualan
$query = "SELECT jumlah, tanggal_pesanan FROM pesanan ORDER BY tanggal_pesanan";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Buat array untuk menyimpan data
$data = array();

// Loop melalui hasil query dan tambahkan ke array data
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Ubah format tanggal menjadi format yang sesuai untuk grafik (misalnya, format 'Y-m-d' menjadi 'd M')
foreach ($data as &$row) {
    $row['tanggal_pesanan'] = date('d M', strtotime($row['tanggal_pesanan']));
}

// Tutup koneksi
mysqli_close($conn);

// Keluarkan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($data);
