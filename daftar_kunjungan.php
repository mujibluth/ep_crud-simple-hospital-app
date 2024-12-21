<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik'];
    $no_rm = $_POST['no_rm'];
    $tgl_kunjungan = $_POST['tgl_kunjungan'];
    $hasil_kunjungan = $_POST['hasil_kunjungan'];
    $biaya = $_POST['biaya'];

    $stmt = $conn->prepare("INSERT INTO kunjungan (nik, no_rm, tgl_kunjungan, hasil_kunjungan, biaya) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $nik,  $no_rm, $tgl_kunjungan, $hasil_kunjungan, $biaya);
    $stmt->execute();
    $stmt->close();
}

$pasien = $conn->query("SELECT * FROM pasien");
$alergi = $conn->query("SELECT * FROM alergi");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Dashboard - SB Admin Pro</title>
        <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="default">
                                    <div class="card mb-4">
                                        <div class="card-header">Form Tambah Kunjungan Pasien</div>
                                        <div class="card-body">
                                            <div class="sbp-preview">
                                                <div class="sbp-preview-content">
                                                    <form class="row g-3" method="POST">
                                                        <div class="col-12">
                                                            <label class="form-label mb-0">Cari NIK dan Nama Pasien</label> <br>
                                                            <small style="color:#a7aeb8">Pastikan sebelum tambah kunjungan, pasien sudah terdaftar di Database. Jika belum, lakukan tambah data pasien baru dulu!</small>
                                                            <select name="nik" class="form-select">
                                                                <?php while ($row = $pasien->fetch_assoc()): ?>
                                                                    <option value="<?= $row['nik'] ?>"><?= $row['nik'] ?> - <?= $row['nama'] ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>

                                                        <hr>

                                                        <div class="col-md-4">
                                                            <label class="form-label">No. RM</label>
                                                            <input type="text" class="form-control" name="no_rm" placeholder="" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Tanggal Kunjungan</label>
                                                            <input name="tgl_kunjungan" class="form-control" type="date" />
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Biaya Kunjungan</label>
                                                            <input name="biaya" class="form-control" type="number" />
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">Hasil Kunjungan</label><small class="text-danger">*</small>
                                                            <textarea type="text" class="form-control" name="hasil_kunjungan" placeholder="Terkena Penyakit Diare; Perlu banyak minum air putih; dll" required></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary">Tambah Kunjungan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.com/libraries/bootstrap-datetimepicker/4.17.37" crossorigin="anonymous"></script>
        <script src="assets/js/litepicker.js"></script>
    </body>
</html>
