<?php
include 'db_connect.php';

// Handle tambah data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $golongan_darah = $_POST['golongan_darah'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat_lengkap = $_POST['alamat_lengkap'];
    $id_kota = $_POST['id_kota'];
    $id_alergi = json_encode($_POST['id_alergi']);

    if (isset($_POST['edit_nik'])) { // Jika ada edit_nik, lakukan update
        $edit_nik = $_POST['edit_nik'];
        $stmt = $conn->prepare("UPDATE pasien SET nik=?, nama=?, jenis_kelamin=?, golongan_darah=?, tgl_lahir=?, alamat_lengkap=?, id_kota=?, id_alergi=? WHERE nik=?");
        $stmt->bind_param("ssssssiss", $nik, $nama, $jenis_kelamin, $golongan_darah, $tgl_lahir, $alamat_lengkap, $id_kota, $id_alergi, $edit_nik);
        $stmt->execute();
        $stmt->close();
    } else { // Jika tidak, tambahkan data baru
        $stmt = $conn->prepare("INSERT INTO pasien (nik, nama, jenis_kelamin, golongan_darah, tgl_lahir, alamat_lengkap, id_kota, id_alergi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssis", $nik, $nama, $jenis_kelamin, $golongan_darah, $tgl_lahir, $alamat_lengkap, $id_kota, $id_alergi);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch data pasien untuk list
$result = $conn->query("SELECT pasien.*, kota.nama AS kota_nama FROM pasien JOIN kota ON pasien.id_kota = kota.id");

// Fetch data untuk form edit jika ada parameter `edit`
$edit_data = null;
if (isset($_GET['edit'])) {
    $nik = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM pasien WHERE nik = '$nik'");
    $edit_data = $edit_result->fetch_assoc();
}

$kota = $conn->query("SELECT * FROM kota");
$alergi = $conn->query("SELECT * FROM alergi");
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Pasien</title>
</head>
<body>
    <h1>CRUD Pasien</h1>

    <form method="POST">
        <input type="hidden" name="edit_nik" value="<?= $edit_data['nik'] ?? '' ?>">

        <label>NIK:</label>
        <input type="text" name="nik" value="<?= $edit_data['nik'] ?? '' ?>" required><br>

        <label>Nama:</label>
        <input type="text" name="nama" value="<?= $edit_data['nama'] ?? '' ?>" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin">
            <option value="Laki-laki" <?= (isset($edit_data['jenis_kelamin']) && $edit_data['jenis_kelamin'] === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
            <option value="Perempuan" <?= (isset($edit_data['jenis_kelamin']) && $edit_data['jenis_kelamin'] === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
        </select><br>

        <label>Golongan Darah:</label>
        <select name="golongan_darah">
            <option value="A" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'A') ? 'selected' : '' ?>>A</option>
            <option value="B" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'B') ? 'selected' : '' ?>>B</option>
            <option value="AB" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'AB') ? 'selected' : '' ?>>AB</option>
            <option value="O" <?= (isset($edit_data['golongan_darah']) && $edit_data['golongan_darah'] === 'O') ? 'selected' : '' ?>>O</option>
        </select><br>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tgl_lahir" value="<?= $edit_data['tgl_lahir'] ?? '' ?>" required><br>

        <label>Alamat Lengkap:</label>
        <textarea name="alamat_lengkap" required><?= $edit_data['alamat_lengkap'] ?? '' ?></textarea><br>

        <label>Kota:</label>
        <select name="id_kota">
            <?php while ($row = $kota->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= (isset($edit_data['id_kota']) && $edit_data['id_kota'] == $row['id']) ? 'selected' : '' ?>><?= $row['nama'] ?></option>
            <?php endwhile; ?>
        </select><br>

        <label>Alergi:</label>
        <?php
        $selected_alergi = isset($edit_data['id_alergi']) ? json_decode($edit_data['id_alergi'], true) : [];
        while ($row = $alergi->fetch_assoc()): ?>
            <input type="checkbox" name="id_alergi[]" value="<?= $row['id'] ?>" <?= in_array($row['id'], $selected_alergi) ? 'checked' : '' ?>> <?= $row['nama'] ?><br>
        <?php endwhile; ?>

        <button type="submit"><?= isset($edit_data) ? 'Update' : 'Tambah' ?></button>
    </form>

    <h2>Daftar Pasien</h2>
    <table border="1">
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
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nik'] ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['jenis_kelamin'] ?></td>
                    <td><?= $row['golongan_darah'] ?></td>
                    <td><?= $row['tgl_lahir'] ?></td>
                    <td><?= $row['alamat_lengkap'] ?></td>
                    <td><?= $row['kota_nama'] ?></td>
                    <td><?= implode(", ", json_decode($row['id_alergi'], true)) ?></td>
                    <td>
                        <a href="?edit=<?= $row['nik'] ?>">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
