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
// Query untuk mengambil total penjualan berdasarkan kategori
$query = "
    SELECT kp.nama_kategori, SUM(p.total_harga) AS total_penjualan
    FROM pesanan p
    JOIN produk pr ON p.produk_id = pr.id
    JOIN kategori_produk kp ON pr.kategori_id = kp.id
    WHERE p.status = 'Selesai'
    GROUP BY kp.nama_kategori
";

$result = mysqli_query($conn, $query);

// Buat array untuk menyimpan data
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($conn);

// Keluarkan data dalam format JSON
echo json_encode($data);
