<?php
require_once 'includes/koneksi.php';
$data = $pdo->query("SELECT * FROM posts ORDER BY tanggal DESC LIMIT 5")->fetchAll();
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Blog Mahasiswa</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0; padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #1e0033;
            color: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        .header {
            width: 100%;
            background-color: #2a0047;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            padding: 40px 20px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header h1 {
            font-size: 32px;
            color: #00d1ff;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .header a {
            margin: 0 10px;
            padding: 12px 26px;
            background: #320058;
            border-radius: 12px;
            color: #00d1ff;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 0 8px #00d1ffaa;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.4s ease;
            display: inline-block;
        }

        .header a:hover {
            background-color: #00d1ff;
            color: #1e0033;
            box-shadow: 0 0 14px #00d1ffee;
        }

        .latest-articles {
            width: 100%;
            max-width: 900px;
            margin-top: 50px;
            padding: 0 20px;
        }

        .latest-articles h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 35px;
            color: #00ffe7;
            font-weight: 700;
            text-shadow: 0 0 6px #00ffe7aa;
        }

        .article {
            background: #300048;
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .article:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0,255,231,0.7);
        }

        .article h3 {
            font-size: 24px;
            color: #00ffe7;
            margin-bottom: 12px;
            font-weight: 700;
            text-shadow: 0 0 5px #00ffe7aa;
        }

        .article small {
            display: block;
            color: #b3b3b3;
            margin-bottom: 20px;
            font-style: italic;
        }

        .article p {
            font-size: 17px;
            line-height: 1.7;
            color: #d1d1d1;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 26px;
            }

            .latest-articles h2 {
                font-size: 24px;
            }

            .article {
                padding: 24px;
            }

            .article h3 {
                font-size: 20px;
            }

            .header a {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 Selamat Datang di Blog Mahasiswa</h1>
        <a href="auth/login.php">🔐 Login</a>
        <a href="auth/register.php">📝 Register</a>
    </div>

    <div class="latest-articles">
        <h2>📰 Artikel Terbaru</h2>
        <?php foreach ($data as $row): ?>
            <div class="article" onclick="location.href='blog/detail_artikel.php?id=<?= htmlspecialchars($row['id']) ?>'">
                <h3><?= htmlspecialchars($row['judul']) ?></h3>
                <small><?= htmlspecialchars($row['tanggal']) ?></small>
                <p><?= substr(strip_tags($row['konten']), 0, 120) ?>...</p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
