-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 31 Okt 2026 pada 06.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sima_mahasiswa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Admin890', '$2y$10$wxXmhIDPqNqvhas6QDz8veE8nuqMNlzHSFZaGfj3uViuo/RlO/sP6', '2026-10-31 01:41:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `semester` tinyint(3) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `jenis_kelamin`, `prodi`, `semester`, `email`, `created_at`, `updated_at`) VALUES
(1, '123456789', 'Adrina Putri A', 'Perempuan', 'Teknik Informatika', 5, 'adrina@gmail.com', '2026-10-31 05:19:47', '2026-10-31 05:40:43'),
(2, '123456788', 'Andri Pratama', 'Laki-laki', 'Teknik Informatika', 5, 'pratamaandri@gmail.com', '2026-10-31 05:20:31', '2026-10-31 05:40:43'),
(3, '123456787', 'Aulia Fatima', 'Perempuan', 'Teknik Informatika', 5, 'fatim@gmail.com', '2026-10-31 05:21:08', '2026-10-31 05:40:43'),
(4, '202010004', 'Sonya Leona', 'Perempuan', 'Hubungan Internasional', 5, 'sonyall@gmail.com', '2026-10-31 05:21:41', '2026-10-31 05:40:43'),
(5, '202010009', 'Sena', 'Laki-laki', 'Hubungan Internasional', 5, 'sena123@gmail.com', '2026-10-31 05:22:20', '2026-10-31 05:40:43'),
(6, '102030402', 'Dira Faradilla', 'Perempuan', 'Psikologi', 5, 'dilladira@gmail.com', '2026-10-31 05:23:23', '2026-10-31 05:40:43'),
(7, '102030406', 'Dirga Wibawa', 'Laki-laki', 'Psikologi', 5, 'dirdirga@gmail.com', '2026-10-31 05:23:56', '2026-10-31 05:40:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
