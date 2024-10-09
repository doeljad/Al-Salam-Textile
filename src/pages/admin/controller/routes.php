<?php
// Ambil parameter dari URL
$params = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Definisikan route
$routes = [
    // Login 
    'login' => 'login.php',

    // Admin
    'dashboard' => 'src/pages/admin/dashboard.php',
    'kategori-produk' => 'src/pages/admin/kategori-produk.php',
    'stok-produk' => 'src/pages/admin/stok-produk.php',
    'pesanan-masuk' => 'src/pages/admin/pesanan-masuk.php',
    'data-pelanggan' => 'src/pages/admin/data-pelanggan.php',
    'data-supplier' => 'src/pages/admin/data-supplier.php',
    'data-pengguna' => 'src/pages/admin/data-pengguna.php',
    'laporan-transaksi' => 'src/pages/admin/laporan-transaksi.php',
    'laporan-pendapatan' => 'src/pages/admin/laporan-pendapatan.php',
    'laporan-pendapatan' => 'src/pages/admin/laporan-pendapatan.php',
    'informasi-toko' => 'src/pages/admin/informasi-toko.php',
    'chat-help-desk' => 'src/pages/admin/chat-help-desk.php',
    'riwayat-pesanan' => 'src/pages/admin/riwayat-pesanan.php',
];

// Periksa apakah URL ada di route
if (isset($routes[$params])) {
    // Tentukan halaman yang akan dimuat
    $page = $routes[$params];
    // Include halaman yang sesuai
    include_once($page);
} else {
    // Jika URL tidak ada di route, redirect ke halaman 404 atau halaman lain yang sesuai
    echo "<script>window.location.href = 'src/pages/error-404.html'</script>";
    exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
}
