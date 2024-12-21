<?php
include 'db_connect.php';

if (isset($_GET['delete'])) {
    $nik = $_GET['delete'];

    // Hapus data pasien berdasarkan NIK
    $stmt = $conn->prepare("DELETE FROM pasien WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $stmt->close();

    header("Location: lihat_pasien.php");
    exit;
} else {
    header("Location: lihat_pasien.php");
    exit;
}