  -- Struktur dari tabel `biodata`
  CREATE TABLE `biodata` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nama` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
    `alamat` text NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  INSERT INTO `biodata` (`id`, `nama`, `email`, `jenis_kelamin`, `alamat`) VALUES
  (1, 'toriqganteng', 'toriqganteng@gmail.com', 'Laki-laki', 'JL.pangerantoriq'),
  (3, 'Azis Toriq Maulana', 'azisthoriq87@gmail.com', 'Laki-laki', 'Ungaran bre'),
  (5, 'maulana', 'informatika@gmail.com', 'Laki-laki', 'Unimus');

  -- Struktur dari tabel `posts`
  CREATE TABLE `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `judul` varchar(255) NOT NULL,
    `konten` text NOT NULL,
    `tanggal` date NOT NULL,
    `status` enum('draft','public','private') DEFAULT 'draft',
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  INSERT INTO `posts` (`id`, `judul`, `konten`, `tanggal`, `status`) VALUES
  (1, 'Unimus Berkeunggulan', 'sulit sih', '2025-05-24', 'draft'),
  (2, 'Pemuda ini pusing coding ga selesai.', 'toriq ganteng sangat pintar prompt AI hehe', '2025-05-24', 'draft'),
  (3, 'BTC CYCLE BULL RUN', 'BITCOIN ASET DUNIA', '2025-05-25', 'draft'),
  (4, 'MAHASISWA INI RAJIN CODING NILAI NYA BAGUS', 'PAK DHENDRA BISMILLAH NILAI A++ NIM C2C023180', '2025-05-25', 'draft'),
  (5, 'KKL 2025', 'Menuju kunjungan ke Surbaya bersama Informatika angkatan 23', '2025-05-26', 'draft'),
  (6, 'Azis Toriq Maulana: Mahasiswa Jago Prompt AI yang Lulus Lebih Awal, Bukti Adaptasi Zaman Now', 'Di era di mana teknologi AI makin ngegas... [konten panjang disingkat]', '2025-05-25', 'draft');

  -- Struktur dari tabel `users`
  CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL UNIQUE,
    `nama_lengkap` varchar(100) NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  INSERT INTO `users` (`id`, `username`, `nama_lengkap`, `password_hash`) VALUES
  (1, 'zistoriqm', 'Azis Toriq Maulana', '$2y$10$Uq1pmXF7CilxCyI0m2XvdOR04hRVxybMXXJU/.tiCphm0cHvXl54K'),
  (2, 'admin', 'admin', '$2y$10$Z655nsc.t/vUCNEEy/AOJOVtmeda.aROMWdueUim8XPFOQDoX52ZS');
