<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ep_data-pasien';
$port = 3307;

// Koneksi ke MySQL
$conn = new mysqli($host, $username, $password, $database, $port);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "Koneksi berhasil";
?>
