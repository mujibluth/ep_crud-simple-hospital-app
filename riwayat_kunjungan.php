<?php 
include 'db_connect.php';
$kunjungan = $conn->query("SELECT * FROM kunjungan");
$result = $conn->query("SELECT * FROM pasien");
$kota = $conn->query("SELECT * FROM kota");
$alergi = $conn->query("SELECT * FROM alergi");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Dashboard - SB Admin Pro</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="assets/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <?php include 'topnav.php'; ?>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <?php include 'sidenav.php'; ?>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <?php include 'header.php'; ?>
                    </header>

                    <div class="container-xl px-4 mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Tabel Riwayat Kunjungan Pasien</div>
                            <div class="card-body table-responsive">
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>Tgl Kunjungan</th>
                                            <th>NIK</th>
                                            <th>No. RM</th>
                                            <th>Hasil Kunjungan</th>
                                            <th>Biaya</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Tgl Kunjungan</th>
                                            <th>NIK</th>
                                            <th>No. RM</th>
                                            <th>Hasil Kunjungan</th>
                                            <th>Biaya</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($row = $kunjungan->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['tgl_kunjungan'] ?></td>
                                                <td><?= $row['nik'] ?></td>
                                                <td><?= $row['no_rm'] ?></td>
                                                <td><?= $row['hasil_kunjungan'] ?></td>
                                                <td><?= $row['biaya'] ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="footer-admin mt-auto footer-light">
                    <?php include 'footer.php'; ?>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="assets/js/datatables/datatables-simple-demo.js"></script>
    </body>
</html>
