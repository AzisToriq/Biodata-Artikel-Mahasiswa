<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$data = $pdo->query("SELECT * FROM posts ORDER BY tanggal DESC")->fetchAll();


$editId = $_GET['edit_id'] ?? null;

$username = $_SESSION['user']['username'] ?? 'User';
$nama = $_SESSION['user']['nama_lengkap'] ?? $username;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Artikel - Blog Mahasiswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0; padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1e0033;
            color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 240px;
            height: 100vh;
            background: #2a0047;
            padding: 20px;
            z-index: 1000;
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
            font-weight: 600;
        }
        .sidebar a:hover {
            background: #471463;
        }
        /* Topbar */
        .topbar {
            margin-left: 240px;
            height: 60px;
            background: #320058;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            position: sticky;
            top: 0;
            z-index: 900;
        }
        .search-box input {
            padding: 8px 14px;
            border-radius: 20px;
            border: none;
            outline: none;
            background: #470078;
            color: white;
            width: 220px;
            font-size: 14px;
        }
        .user-info {
            font-weight: 600;
            font-size: 16px;
            color: #00ffe7;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }
        .logout-btn:hover {
            background: #c0392b;
        }
        /* Main content */
        .content {
            margin-left: 240px;
            padding: 30px 40px 60px;
            flex-grow: 1;
        }
        h2 {
            color: #00d1ff;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 40px;
        }
        /* Cards grid */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        /* Card */
        .card {
            background: #300048;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            outline: none;
            color: #eee;
        }
        .card:hover, .card:focus {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,255,255,0.7);
            background: #40005f;
            color: #00ffe7;
        }
        /* Highlight editing card */
        .card-editing {
            background-color: #002b49;
            border: 3px solid #00d1ff;
            box-shadow: 0 0 24px #00d1ff;
            transform: scale(1.05);
        }
        .card h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            color: inherit;
        }
        .card small {
            color: #88cfff;
            font-size: 13px;
            display: block;
            margin-bottom: 16px;
        }
        .card p {
            font-size: 14px;
            line-height: 1.6;
            color: #ccc;
            margin-bottom: 0;
        }
        .card-link {
            color: inherit;
            text-decoration: none;
            display: block;
        }
        .card-link:hover h3,
        .card-link:hover small,
        .card-link:hover p {
            color: #00ffe7;
        }
        /* Actions buttons */
        .card-actions {
            margin-top: 18px;
            display: flex;
            gap: 14px;
        }
        .card-actions a {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            background: #00d1ff;
            color: #1e0033;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 6px 18px rgba(0, 209, 255, 0.6);
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        .card-actions a:hover {
            background: #00a6cc;
            box-shadow: 0 8px 22px rgba(0, 166, 204, 0.8);
            color: white;
        }
        .card-actions a.delete-link {
            background: #e74c3c;
            box-shadow: 0 6px 18px rgba(231, 76, 60, 0.6);
            color: white;
        }
        .card-actions a.delete-link:hover {
            background: #c0392b;
            box-shadow: 0 8px 22px rgba(192, 57, 43, 0.8);
        }
        /* Bottom action links */
        .action-links {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            gap: 24px;
        }
        .action-links a {
            background: #00d1ff;
            padding: 14px 28px;
            color: #1e0033;
            font-weight: 700;
            border-radius: 20px;
            box-shadow: 0 6px 18px rgba(0, 209, 255, 0.6);
            text-decoration: none;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        .action-links a:hover {
            background: #0099cc;
            color: white;
            box-shadow: 0 8px 22px rgba(0,153,204,0.8);
        }
        /* Responsive */
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 20px;
            }
            .sidebar, .topbar {
                display: none;
            }
            .grid-container {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .action-links {
                flex-direction: column;
                gap: 16px;
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
    </div>

    <div class="topbar">
        <div class="search-box">
            <input type="text" placeholder="Cari artikel..." disabled />
        </div>
        <div class="user-info">
            👋 <?= htmlspecialchars($nama) ?>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <main class="content">
        <h2>📰 Artikel Blog</h2>

        <div class="grid-container">
            <?php foreach ($data as $row):
                $isEditing = ($row['id'] == $editId);
                $cardClass = $isEditing ? 'card card-editing' : 'card';
            ?>
                <div class="<?= $cardClass ?>" tabindex="0" role="article" aria-label="<?= htmlspecialchars($row['judul']) ?>">
                    <a href="detail_artikel.php?id=<?= $row['id'] ?>" class="card-link">
                        <h3><?= htmlspecialchars($row['judul']) ?></h3>
                        <small><?= $row['tanggal'] ?></small>
                        <p><?= substr(strip_tags($row['konten']), 0, 120) ?>...</p>
                    </a>
                    <div class="card-actions">
                        <a href="edit_artikel.php?id=<?= $row['id'] ?>">Edit <i class="fa fa-pen"></i></a>
                        <a href="hapus_artikel.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Yakin ingin menghapus artikel ini?')">Hapus <i class="fa fa-trash"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="action-links">
            <a href="tambah_artikel.php">+ Tambah Artikel</a>
            <a href="../dashboard.php">← Kembali ke Dashboard</a>
        </div>
    </main>

</body>
</html>
