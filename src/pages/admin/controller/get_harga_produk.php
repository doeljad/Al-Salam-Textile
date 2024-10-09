<?php
// Menghubungkan ke database
include('../../../config/koneksi.php');

// Memeriksa apakah id_produk sudah di-set dalam permintaan GET
if (isset($_GET['id_produk'])) {
    $id_produk = intval($_GET['id_produk']);

    // Membuat query untuk mengambil harga produk berdasarkan id_produk
    $sql = "SELECT harga FROM produk WHERE id = $id_produk";
    $result = $conn->query($sql);

    // Memeriksa apakah hasil query memiliki baris yang cocok
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Mengembalikan harga dalam format JSON
        echo json_encode(['harga' => $row['harga']]);
    } else {
        // Jika tidak ada baris yang cocok, mengembalikan harga 0 dalam format JSON
        echo json_encode(['harga' => 0]);
    }
} else {
    // Jika id_produk tidak di-set, mengembalikan harga 0 dalam format JSON
    echo json_encode(['harga' => 0]);
}

// Menutup koneksi ke database
$conn->close();
