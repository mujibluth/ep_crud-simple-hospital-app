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

    $stmt = $conn->prepare("INSERT INTO pasien (nik, nama, jenis_kelamin, golongan_darah, tgl_lahir, alamat_lengkap, id_kota, id_alergi) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $nik, $nama, $jenis_kelamin, $golongan_darah, $tgl_lahir, $alamat_lengkap, $id_kota, $id_alergi);
    $stmt->execute();
    $stmt->close();
}

// Fetch data pasien
$result = $conn->query("SELECT * FROM pasien");
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
        <label>NIK:</label>
        <input type="text" name="nik" required><br>

        <label>Nama:</label>
        <input type="text" name="nama" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin">
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label>Golongan Darah:</label>
        <select name="golongan_darah">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="AB">AB</option>
            <option value="O">O</option>
        </select><br>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tgl_lahir" required><br>

        <label>Alamat Lengkap:</label>
        <textarea name="alamat_lengkap" required></textarea><br>

        <label>Kota:</label>
        <select name="id_kota">
            <?php while ($row = $kota->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
            <?php endwhile; ?>
        </select><br>

        <label>Alergi:</label>
        <?php while ($row = $alergi->fetch_assoc()): ?>
            <input type="checkbox" name="id_alergi[]" value="<?= $row['id'] ?>"> <?= $row['nama'] ?><br>
        <?php endwhile; ?>

        <button type="submit">Tambah</button>
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
                    <td><?= $row['id_kota'] ?></td>
                    <td><?= $row['id_alergi'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
