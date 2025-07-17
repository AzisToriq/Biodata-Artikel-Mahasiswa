-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2025 pada 14.51
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
-- Database: `ujian_web`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodata`
--

CREATE TABLE `biodata` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biodata`
--

INSERT INTO `biodata` (`id`, `nama`, `email`, `jenis_kelamin`, `alamat`) VALUES
(1, 'toriqganteng', 'toriqganteng@gmail.com', 'Laki-laki', 'JL.pangerantoriq'),
(3, 'Azis Toriq Maulana', 'azisthoriq87@gmail.com', 'Laki-laki', 'Ungaran bre'),
(5, 'maulana', 'informatika@gmail.com', 'Laki-laki', 'Unimus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('draft','public','private') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `posts`
--

INSERT INTO `posts` (`id`, `judul`, `konten`, `tanggal`, `status`) VALUES
(1, 'Unimus Berkeunggulan', 'sulit sih', '2025-05-24', 'draft'),
(2, 'Pemuda ini pusing coding ga selesai.', 'toriq ganteng sangat pintar prompt AI hehe', '2025-05-24', 'draft'),
(3, 'BTC CYCLE BULL RUN', 'BITCOIN ASET DUNIA', '2025-05-25', 'draft'),
(4, 'MAHASISWA INI RAJIN CODING NILAI NYA BAGUS', 'PAK DHENDRA BISMILLAH NILAI A++ NIM C2C023180', '2025-05-25', 'draft'),
(5, 'KKL 2025', 'Menuju kunjungan ke Surbaya bersama Informatika angkatan 23', '2025-05-26', 'draft'),
(6, 'Azis Toriq Maulana: Mahasiswa Jago Prompt AI yang Lulus Lebih Awal, Bukti Adaptasi Zaman Now', 'Di era di mana teknologi AI makin ngegas dan merasuk ke segala aspek kehidupan, ada satu sosok mahasiswa yang berhasil bikin gebrakan dengan cara yang unik dan cerdas. Namanya Azis Toriq Maulana, mahasiswa yang bukan cuma pinter belajar, tapi juga pinter memanfaatkan kecanggihan AI lewat kemampuan prompt engineering yang mumpuni. Hasilnya? Dia lulus kuliah lebih awal dari yang diperkirakan banyak orang.\r\n\r\nAdaptasi Cepat, Kunci Sukses Azis\r\nAzis paham betul bahwa dunia sekarang bukan cuma soal kerja keras, tapi juga kerja cerdas. Dia gak cuma jadi pengguna AI, tapi benar-benar menguasai cara mengoptimalkan interaksi dengan AI agar hasil yang didapat maksimal. Skill ini, yang disebut prompt engineering, bikin dia bisa menyelesaikan tugas kuliah dan riset dengan efisiensi tinggi tanpa kehilangan kualitas.\r\n\r\nKompetibel dengan AI, Bukan Kompetitor\r\nKunci keberhasilan Azis bukan cuma jago pakai AI, tapi bagaimana dia menjadikan AI sebagai partner kolaborasi. Dia gak takut tergantikan oleh mesin, tapi justru melihat AI sebagai alat untuk mempercepat proses belajar dan bekerja. Pendekatan ini bikin dia jadi contoh nyata bagaimana generasi muda bisa survive dan thrive di dunia yang semakin digital dan otomatis.\r\n\r\nWawasan ke Depan: AI sebagai Katalisator Perubahan\r\nAzis juga punya pandangan yang jauh ke depan. Dia percaya bahwa skill prompt engineering akan jadi salah satu kompetensi paling dicari di masa depan. Bagi dia, lulus lebih awal bukan sekadar prestasi akademik, tapi bukti nyata adaptasi dengan perubahan zaman yang super cepat.\r\n\r\nIntinya, Azis Toriq Maulana mengajarkan kita bahwa menguasai teknologi—terutama AI—bukan hanya soal tahu fungsi, tapi bagaimana menggunakannya secara strategis. Generasi Z kayak Azis ini yang bakal jadi pionir perubahan, bikin masa depan makin cerah dan penuh inovasi.', '2025-05-25', 'draft');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `nama_lengkap`, `password_hash`) VALUES
(1, 'zistoriqm', 'Azis Toriq Maulana', '$2y$10$Uq1pmXF7CilxCyI0m2XvdOR04hRVxybMXXJU/.tiCphm0cHvXl54K'),
(2, 'admin', 'admin', '$2y$10$Z655nsc.t/vUCNEEy/AOJOVtmeda.aROMWdueUim8XPFOQDoX52ZS');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `biodata`
--
ALTER TABLE `biodata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
