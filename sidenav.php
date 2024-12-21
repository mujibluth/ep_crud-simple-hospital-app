<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboards
            </a>

            <div class="sidenav-menu-heading">Data Pasien</div>
            <a class="nav-link <?php echo ($current_page == 'tambah_pasien.php') ? 'active' : ''; ?>" href="tambah_pasien.php">
                <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                Pasien Baru
            </a>
            <a class="nav-link <?php echo ($current_page == 'lihat_pasien.php') ? 'active' : ''; ?>" href="lihat_pasien.php">
                <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                Lihat & Ubah Pasien
            </a>

            <div class="sidenav-menu-heading">Data Kunjungan</div>
            <a class="nav-link <?php echo ($current_page == 'daftar_kunjungan.php') ? 'active' : ''; ?>" href="daftar_kunjungan.php">
                <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                Daftar Kunjungan
            </a>
            <a class="nav-link <?php echo ($current_page == 'riwayat_kunjungan.php') ? 'active' : ''; ?>" href="riwayat_kunjungan.php">
                <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                Riwayat Kunjungan
            </a>

            <div class="sidenav-menu-heading">Pelaporan</div>
            <a class="nav-link <?php echo ($current_page == 'laporan_keuangan.php') ? 'active' : ''; ?>" href="laporan_keuangan.php">
                <div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                Laporan Keuangan
            </a>
        </div>
    </div>
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">Valerie Luna</div>
        </div>
    </div>
</nav>