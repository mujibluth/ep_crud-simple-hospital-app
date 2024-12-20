CREATE DATABASE IF NOT EXISTS `ep_data-pasien`;
USE `ep_data-pasien`;

-- Tabel kota
CREATE TABLE `kota` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed data kota
INSERT INTO `kota` (`nama`) VALUES ('Boyolali'), ('Klaten'), ('Salatiga'), ('Sragen'), ('Sukoharjo'), ('Surakarta');

-- Tabel alergi
CREATE TABLE `alergi` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed data alergi
INSERT INTO `alergi` (`nama`) VALUES ('Obat'), ('Makanan'), ('Debu'), ('Serangga');

-- Tabel pasien
CREATE TABLE `pasien` (
    `nik` VARCHAR(16) PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
    `golongan_darah` ENUM('A', 'B', 'AB', 'O') NOT NULL,
    `tgl_lahir` DATE NOT NULL,
    `alamat_lengkap` TEXT NOT NULL,
    `id_kota` INT NOT NULL,
    `id_alergi` TEXT NOT NULL, -- Disimpan dalam format JSON
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_kota`) REFERENCES `kota`(`id`)
);

-- Tabel kunjungan
CREATE TABLE `kunjungan` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `no_rm` VARCHAR(20) NOT NULL,
    `nik` VARCHAR(16) NOT NULL,
    `tgl_kunjungan` DATE NOT NULL,
    `hasil_kunjungan` TEXT NOT NULL,
    `biaya` DECIMAL(10, 2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`nik`) REFERENCES `pasien`(`nik`)
);

-- Tabel keuangan
CREATE TABLE `keuangan` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_kunjungan` INT NOT NULL,
    `status` ENUM('pemasukan', 'pengeluaran') NOT NULL,
    `keterangan` TEXT NOT NULL,
    `biaya` DECIMAL(10, 2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_kunjungan`) REFERENCES `kunjungan`(`id`)
);
