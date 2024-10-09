<?php
// Tangkap halaman yang sedang dibuka
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item <?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
            <a class="nav-link" href="?page=dashboard">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item nav-category">Laporan</li>
        <li class="nav-item <?php echo ($page == 'kategori-produk') ? 'active' : ''; ?>">
            <a class="nav-link" href="?page=kategori-produk">
                <i class="menu-icon mdi mdi-tag-multiple"></i>
                <span class="menu-title">Kategori Produk</span>
            </a>
        </li>

        <li class="nav-item <?php echo ($page == 'stok-produk') ? 'active' : ''; ?>">
            <a class="nav-link " href="?page=stok-produk">
                <i class="menu-icon mdi mdi-cube-outline"></i>
                <span class="menu-title">Stok Produk</span>
            </a>
        </li>

        <li class="nav-item <?php echo ($page == 'pesanan-masuk') ? 'active' : ''; ?>">
            <a class="nav-link " href="?page=pesanan-masuk">
                <i class="menu-icon mdi mdi-inbox-arrow-down"></i>
                <span class="menu-title">Pesanan Masuk</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($page == 'data-pelanggan') ? 'active' : ''; ?>">
            <a class="nav-link " href="?page=data-pelanggan">
                <i class="menu-icon mdi mdi-account-multiple"></i>
                <span class="menu-title">Data Pelanggan</span>
            </a>
        </li>

        <li class="nav-item nav-category">Laporan Penjualan</li>
        <li class="nav-item  <?php echo ($page == 'laporan-transaksi') ? 'active' : ''; ?>">
            <a class="nav-link" href="?page=laporan-transaksi">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Laporan Transaksi</span>
            </a>
        </li>
        <li class="nav-item  <?php echo ($page == 'laporan-pendapatan') ? 'active' : ''; ?>">
            <a class="nav-link" href="?page=laporan-pendapatan">
                <i class="menu-icon mdi mdi-cash-multiple"></i>
                <span class="menu-title">Laporan Pendapatan</span>
            </a>
        </li>
    </ul>
</nav>