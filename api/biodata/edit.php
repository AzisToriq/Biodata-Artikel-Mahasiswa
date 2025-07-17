<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: daftar.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM biodata WHERE id = ?");
$stmt->execute([$id]);
$biodata = $stmt->fetch();

if (!$biodata) {
    header("Location: daftar.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = trim($_POST['alamat']);

    if (!$nama || !$email || !$jenis_kelamin || !$alamat) {
        $error = "Semua field wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid!";
    } else {
        $stmt = $pdo->prepare("UPDATE biodata SET nama = ?, email = ?, jenis_kelamin = ?, alamat = ? WHERE id = ?");
        $stmt->execute([$nama, $email, $jenis_kelamin, $alamat, $id]);
        header("Location: daftar.php");
        exit;
    }
}

$username = $_SESSION['user']['username'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Biodata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
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
        .sidebar a:hover, .sidebar a.active {
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
        .form-card {
            background: #300048;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            max-width: 600px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: #470078;
            color: white;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .btn-primary, .btn-secondary {
            background: #00d1ff;
            color: black;
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-right: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-secondary {
            background: #888;
            color: white;
        }
        .error-msg {
            background: #ff4d4d;
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="../dashboard.php"><i class="fa fa-chart-line"></i> Dashboard</a>
        <a href="daftar.php" class="active"><i class="fa fa-user-graduate"></i> Data Mahasiswa</a>
        <a href="../blog/index.php"><i class="fa fa-newspaper"></i> Artikel Blog</a>
        <a href="../auth/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Topbar -->
    <div class="topbar">
        <h1>Edit Biodata</h1>
        <div class="user-info">
            👤 <?= htmlspecialchars($username) ?>
        </div>
    </div>

    <!-- Form Content -->
    <div class="dashboard-content">
        <?php if ($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="" class="form-card">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? $biodata['nama']) ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? $biodata['email']) ?>">
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="Laki-laki" <?= (($_POST['jenis_kelamin'] ?? $biodata['jenis_kelamin']) === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= (($_POST['jenis_kelamin'] ?? $biodata['jenis_kelamin']) === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" required><?= htmlspecialchars($_POST['alamat'] ?? $biodata['alamat']) ?></textarea>
            </div>

            <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
            <a href="daftar.php" class="btn-secondary">⬅️ Kembali</a>
        </form>
    </div>
</body>
</html>
