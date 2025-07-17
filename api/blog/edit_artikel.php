<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$error = '';
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$artikel = $stmt->fetch();

if (!$artikel) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $konten = trim($_POST['konten']);
    $tanggal = $_POST['tanggal'];

    if ($judul && $konten && $tanggal) {
        $stmt = $pdo->prepare("UPDATE posts SET judul = ?, konten = ?, tanggal = ? WHERE id = ?");
        $stmt->execute([$judul, $konten, $tanggal, $id]);
        header("Location: index.php");
        exit;
    } else {
        $error = "Semua field wajib diisi!";
    }
}

$username = $_SESSION['user']['username'] ?? 'User';
$nama = $_SESSION['user']['nama_lengkap'] ?? $username;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Artikel</title>
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
        .dashboard-content {
            margin-left: 240px;
            padding: 30px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #2b0050;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00ffe7;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1.5px solid #666;
            border-radius: 10px;
            background: #1a0033;
            color: #fff;
            font-size: 16px;
        }

        input:focus, textarea:focus {
            border-color: #00d1ff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            background: #00d1ff;
            border: none;
            color: #000;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #00a3cc;
        }

        .error-message {
            color: #ff6b6b;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #00d1ff;
        }

        .back-link:hover {
            color: #00a3cc;
        }

        .search-box input {
            padding: 8px 14px;
            border-radius: 20px;
            border: none;
            outline: none;
            background: #470078;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="../index.php"><i class="fa fa-chart-line"></i> Dashboard</a>
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
            <a href="../logout.php" class="logout-btn" style="margin-left: 15px; background: #e74c3c; color: white; padding: 8px 14px; border-radius: 8px; text-decoration: none;">Logout</a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="form-container">
            <h2>Edit Artikel</h2>
            <?php if ($error): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <input type="text" name="judul" placeholder="Judul Artikel" required value="<?= htmlspecialchars($_POST['judul'] ?? $artikel['judul']) ?>" />
                <textarea name="konten" placeholder="Isi Artikel" rows="6" required><?= htmlspecialchars($_POST['konten'] ?? $artikel['konten']) ?></textarea>
                <input type="date" name="tanggal" required value="<?= htmlspecialchars($_POST['tanggal'] ?? $artikel['tanggal']) ?>" />
                <button type="submit">Update Artikel</button>
            </form>
            <a href="index.php" class="back-link">⬅️ Kembali ke Daftar Artikel</a>
        </div>
    </div>
</body>
</html>
