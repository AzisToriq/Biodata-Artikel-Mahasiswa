<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
require_once 'includes/koneksi.php';

// Keamanan sesi
if (!isset($_SESSION['user']) || empty($_SESSION['user']['username'])) {
    session_destroy();
    header("Location: auth/login.php");
    exit;
}

$username = $_SESSION['user']['username'] ?? 'User';
$nama = $_SESSION['user']['nama_lengkap'] ?? $username;
$lastLogin = $_SESSION['user']['last_login'] ?? 'Baru login pertama';

// Ambil data statistik
$stmtMahasiswa = $pdo->query("SELECT COUNT(*) FROM biodata");
$totalMahasiswa = $stmtMahasiswa->fetchColumn();

$stmtArtikel = $pdo->query("SELECT COUNT(*) FROM posts");
$totalArtikel = $stmtArtikel->fetchColumn();

// Salam dinamis berdasarkan jam
$hour = date("H");
if ($hour < 12) {
    $salam = "Selamat Pagi";
} elseif ($hour < 17) {
    $salam = "Selamat Siang";
} else {
    $salam = "Selamat Malam";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            background: linear-gradient(180deg, #2a0047, #18002f);
            padding: 20px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.5);
        }
        .sidebar h2 {
            color: #00ffe7;
            margin-bottom: 40px;
            font-weight: 700;
            font-size: 24px;
            text-align: center;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #ccc;
            text-decoration: none;
            padding: 12px 16px;
            margin-bottom: 12px;
            font-weight: 500;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.3s ease, color 0.3s ease;
        }
        .sidebar a:hover {
            background: #470078;
            color: #00ffe7;
            transform: translateX(8px);
            box-shadow: 0 0 12px #00ffe7;
        }
        .sidebar a.active {
            background-color: #6200a8;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 0 10px #00ffe7;
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
        }
        .quick-links {
            margin-bottom: 20px;
        }
        .quick-links a {
            background: #00ffe7;
            color: #000;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-right: 10px;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .quick-links a:nth-child(2) {
            background: #ff4da6;
            color: #fff;
        }
        .quick-links a:hover {
            filter: brightness(0.9);
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        .card {
            background: #300048;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: default;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }
        .card h3 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #00ffe7;
        }
        .card p {
            font-size: 16px;
            color: #ccc;
        }
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
            font-weight: 600;
            color: #00ffe7;
        }
        .user-info p {
            margin: 0;
            font-size: 12px;
            color: #bbb;
        }
        .chart-section {
            margin-top: 40px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        canvas {
            background: #2b0048;
            border-radius: 12px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="#" class="active"><i class="fa fa-chart-line"></i> Dashboard</a>
        <a href="biodata/daftar.php"><i class="fa fa-user-graduate"></i> Data Mahasiswa</a>
        <a href="blog/index.php"><i class="fa fa-newspaper"></i> Artikel Blog</a>
    </div>

    <div class="topbar">
        <div class="search-box">
            <input type="text" placeholder="Cari..." disabled />
        </div>
        <div class="user-info">
            <span id="clock"></span>
            <?= $salam ?>, <?= htmlspecialchars($nama) ?> 👋
            <p>Login terakhir: <?= $lastLogin ?></p>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="quick-links">
            <a href="biodata/tambah.php">+ Tambah Mahasiswa</a>
            <a href="blog/tambah_artikel.php">+ Tulis Artikel</a>
        </div>

        <div class="cards">
            <div class="card" title="Klik untuk lihat data lengkap!">
                <h3><?= $totalMahasiswa ?></h3>
                <p>Jumlah Mahasiswa</p>
            </div>
            <div class="card" title="Klik untuk lihat artikel!">
                <h3><?= $totalArtikel ?></h3>
                <p>Total Artikel</p>
            </div>
        </div>

        <div class="chart-section">
            <h3>Statistik Data</h3>
            <canvas id="myChart" width="300" height="300"></canvas>
        </div>
    </div>

    <script>
        // Real-time clock
        setInterval(() => {
            const now = new Date();
            document.getElementById("clock").textContent =
                now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }, 1000);

        // Chart.js Doughnut Chart
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Mahasiswa', 'Artikel'],
                datasets: [{
                    data: [<?= $totalMahasiswa ?>, <?= $totalArtikel ?>],
                    backgroundColor: ['#00ffe7', '#ff4da6'],
                    borderColor: '#1e0033',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffffff'
                        }
                    }
                },
                cutout: '60%'
            }
        });
    </script>
</body>
</html>
