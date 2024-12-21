<?php 
include 'db_connect.php';
$result = $conn->query("
    SELECT 
        p.nik,
        p.nama,
        p.jenis_kelamin,
        p.golongan_darah,
        p.tgl_lahir,
        p.alamat_lengkap,
        k.nama AS nama_kota,
        p.id_alergi
    FROM pasien p
    JOIN kota k ON p.id_kota = k.id
");

$alergiData = [];
$alergiResult = $conn->query("SELECT id, nama FROM alergi");
while ($row = $alergiResult->fetch_assoc()) {
    $alergiData[$row['id']] = $row['nama'];
}

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

                    <div class="px-4 mt-n10">
                        <div class="card mb-4">
                            <div class="card-header">Tabel Data Pasien</div>
                            <div class="card-body table-responsive">
                                <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Golongan Darah</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Alergi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Golongan Darah</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Alergi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <?php 
                                            $alergiIds = json_decode($row['id_alergi'], true);
                                            $alergiNames = [];
                                            foreach ($alergiIds as $id) {
                                                if (isset($alergiData[$id])) {
                                                    $alergiNames[] = $alergiData[$id];
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td><?= $row['nik'] ?></td>
                                                <td><?= $row['nama'] ?></td>
                                                <td><?= $row['jenis_kelamin'] ?></td>
                                                <td><?= $row['golongan_darah'] ?></td>
                                                <td><?= $row['tgl_lahir'] ?></td>
                                                <td><?= $row['alamat_lengkap'] ?></td>
                                                <td><?= $row['nama_kota'] ?></td>
                                                <td><?= implode(', ', $alergiNames) ?></td>
                                                <td>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="edit_pasien.php?edit=<?= $row['nik'] ?>"><i data-feather="edit"></i></a>
                                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" href="delete_pasien.php?delete=<?= $row['nik'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?');"><i data-feather="trash-2"></i></a>
                                                </td>
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
