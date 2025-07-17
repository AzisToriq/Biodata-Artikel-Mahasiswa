<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['user']['username'] ?? 'User';
$nama = $_SESSION['user']['nama_lengkap'] ?? $username;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $konten = trim($_POST['konten']);
    $tanggal = $_POST['tanggal'];

    if ($judul && $konten && $tanggal) {
        $stmt = $pdo->prepare("INSERT INTO posts (judul, konten, tanggal) VALUES (?, ?, ?)");
        $stmt->execute([$judul, $konten, $tanggal]);
        header("Location: index.php");
        exit;
    } else {
        $error = "Semua field wajib diisi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Artikel - Dashboard Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0; padding: 0;
        }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #1e0033;
            color: #f5f5f5;
        }
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 240px;
            height: 100vh;
            background: #2a0047;
            padding: 20px;
        }
        .sidebar h2 {
            color: #00d1ff;
            margin-bottom: 40px;
        }
        .sidebar a {
            display: block;
            color: #eee;
            text-decoration: none;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #471463;
        }
        .topbar {
            margin-left: 240px;
            height: 60px;
            background: #320058;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }
        .search-box input {
            padding: 8px 14px;
            border-radius: 20px;
            border: none;
            outline: none;
            background: #470078;
            color: white;
        }
        .dashboard-content {
            margin-left: 240px;
            padding: 30px;
            max-width: 700px;
        }
        h2 {
            color: #00d1ff;
            margin-bottom: 25px;
            text-align: center;
        }
        form {
            background: #300048;
            padding: 25px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
        }
        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            resize: vertical;
            background: #470078;
            color: white;
            transition: background-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus {
            background-color: #5c00a0;
            outline: none;
        }
        button {
            width: 100%;
            background-color: #00d1ff;
            color: #1e0033;
            font-size: 18px;
            padding: 14px 0;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #00a2cc;
            color: white;
        }
        .error-message {
            color: #e74c3c;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        .back-link {
            display: block;
            margin-top: 25px;
            text-align: center;
            font-weight: 600;
            text-decoration: none;
            color: #00d1ff;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #00a2cc;
        }
        @media (max-width: 768px) {
            .dashboard-content {
                margin-left: 0;
                padding: 20px;
                max-width: 100%;
            }
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: flex;
                justify-content: space-around;
            }
            .topbar {
                margin-left: 0;
                padding: 10px 20px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="../dashboard.php"><i class="fa fa-chart-line"></i> Dashboard</a>
        <a href="../biodata/daftar.php"><i class="fa fa-user-graduate"></i> Data Mahasiswa</a>
        <a href="index.php"><i class="fa fa-newspaper"></i> Artikel Blog</a>
        <a href="#"><i class="fa fa-gear"></i> Pengaturan</a>
    </div>

    <div class="topbar">
        <div class="search-box">
            <input type="text" placeholder="Cari..." disabled />
        </div>
        <div class="user-info">
            👋 <?= htmlspecialchars($nama) ?>
            <a href="../logout.php" class="logout-btn" style="color:#e74c3c; margin-left: 15px; font-weight: 700; text-decoration:none;">Logout</a>
        </div>
    </div>

    <div class="dashboard-content">
        <h2>Tambah Artikel Baru</h2>
        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="judul" placeholder="Judul Artikel" required value="<?= htmlspecialchars($_POST['judul'] ?? '') ?>" />
            <textarea name="konten" placeholder="Isi Artikel" rows="6" required><?= htmlspecialchars($_POST['konten'] ?? '') ?></textarea>
            <input type="date" name="tanggal" required value="<?= htmlspecialchars($_POST['tanggal'] ?? '') ?>" />
            <button type="submit">Simpan Artikel</button>
        </form>
        <a href="index.php" class="back-link">⬅️ Kembali ke Daftar Artikel</a>
    </div>
</body>
</html>
