<?php
include 'db_connect.php';

if (!isset($_GET['edit'])) {
    header("Location: lihat_pasien.php");
    exit;
}

$nik = $_GET['edit'];
$edit_result = $conn->query("SELECT * FROM pasien WHERE nik = '$nik'");
$edit_data = $edit_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $golongan_darah = $_POST['golongan_darah'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat_lengkap = $_POST['alamat_lengkap'];
    $id_kota = $_POST['id_kota'];
    $id_alergi = json_encode($_POST['id_alergi']);

    $stmt = $conn->prepare("UPDATE pasien SET nama=?, jenis_kelamin=?, golongan_darah=?, tgl_lahir=?, alamat_lengkap=?, id_kota=?, id_alergi=? WHERE nik=?");
    $stmt->bind_param("sssssssi", $nama, $jenis_kelamin, $golongan_darah, $tgl_lahir, $alamat_lengkap, $id_kota, $id_alergi, $nik);
    $stmt->execute();
    $stmt->close();

    header("Location: lihat_pasien.php");
    exit;
}

// Fetch data untuk dropdown kota dan alergi
$kota = $conn->query("SELECT * FROM kota");
$alergi = $conn->query("SELECT * FROM alergi");
$selected_alergi = json_decode($edit_data['id_alergi'], true);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Dashboard - SB Admin Pro</title>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="default">
                                    <div class="card mb-4">
                                        <div class="card-header">Form Edit Data Pasien</div>
                                        <div class="card-body">
                                            <div class="sbp-preview">
                                                <div class="sbp-preview-content">
                                                    <form class="row g-3" method="POST">
                                                        <input type="hidden" name="edit_nik" value="<?= $edit_data['nik'] ?? '' ?>">
                                                        <div class="col-md-4">
                                                            <label class="form-label">NIK</label><small class="text-danger">*</small>
                                                            <input type="text" class="form-control" name="nik" placeholder="" value="<?= $edit_data['nik'] ?? '' ?>" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nama</label><small class="text-danger">*</small>
                                                            <input type="text" class="form-control" name="nama" placeholder="" value="<?= $edit_data['nama'] ?? '' ?>" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Jenis Kelamin</label><small class="text-danger">*</small>
                                                            <select name="jenis_kelamin" class="form-select" required>
                                                                <option value="Laki-laki" <?= (isset($edit_data['jenis_kelamin']) && $edit_data['jenis_kelamin'] === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                                                <option value="Perempuan" <?= (isset($edit_data['jenis_kelamin']) && $edit_data['jenis_kelamin'] === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <label class="form-label">Alergi:</label><small class="text-danger">*</small> <br>
                                                            <?php
                                                            $selected_alergi = isset($edit_data['id_alergi']) ? json_decode($edit_data['id_alergi'], true) : [];
                                                            while ($row = $alergi->fetch_assoc()): ?>
                                                                <input type="checkbox" name="id_alergi[]" value="<?= $row['id'] ?>" <?= in_array($row['id'], $selected_alergi) ? 'checked' : '' ?>> <?= $row['nama'] ?><br>
                                                            <?php endwhile; ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Golongan Darah</label><small class="text-danger">*</small>
                                                            <select name="golongan_darah" class="form-select" required>
                                                                <option value="A" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'A') ? 'selected' : '' ?>>A</option>
                                                                <option value="B" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'B') ? 'selected' : '' ?>>B</option>
                                                                <option value="AB" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'AB') ? 'selected' : '' ?>>AB</option>
                                                                <option value="O" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'O') ? 'selected' : '' ?>>O</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Tempat Lahir</label><small class="text-danger">*</small>
                                                            <select name="id_kota" class="form-select" required>
                                                                <?php while ($row = $kota->fetch_assoc()): ?>
                                                                    <option value="<?= $row['id'] ?>" <?= (isset($edit_data['id_kota']) && $edit_data['id_kota'] == $row['id']) ? 'selected' : '' ?>><?= $row['nama'] ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">Tanggal Lahir</label><small class="text-danger">*</small>
                                                            <input name="tgl_lahir" class="form-control" type="date" value="<?= $edit_data['tgl_lahir'] ?? '' ?>" required />
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">Alamat Lengkap</label><small class="text-danger">*</small>
                                                            <textarea type="text" class="form-control" name="alamat_lengkap" placeholder="1234 Main St" required><?= $edit_data['alamat_lengkap'] ?? '' ?></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary">Update Data</button>
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
    </body>
</html>
