<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

$keyword = $_GET['search'] ?? '';

if ($keyword) {
    $stmt = $pdo->prepare("SELECT * FROM biodata WHERE nama LIKE :keyword OR email LIKE :keyword ORDER BY id DESC");
    $stmt->execute(['keyword' => "%$keyword%"]);
    $data = $stmt->fetchAll();
} else {
    $data = $pdo->query("SELECT * FROM biodata ORDER BY id DESC")->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Biodata - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        /* --- COPY STYLE DASHBOARD FULL --- */
        * {
            box-sizing: border-box;
            margin: 0; padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            font-weight: 700;
            font-size: 1.8rem;
        }
        .sidebar a {
            display: block;
            color: #eee;
            text-decoration: none;
            padding: 14px 16px;
            margin-bottom: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #471463;
            color: #00ffe7;
        }
        .topbar {
            margin-left: 240px;
            height: 60px;
            background: #320058;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            z-index: 10;
        }
        .search-box input {
            padding: 8px 16px;
            border-radius: 30px;
            border: none;
            outline: none;
            background: #470078;
            color: white;
            width: 320px;
            font-size: 1rem;
            transition: background 0.3s ease;
        }
        .search-box input:focus {
            background: #5f009f;
        }
        .user-info {
            font-weight: 600;
            font-size: 1rem;
            color: #00ffe7;
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }
        .logout-btn:hover {
            background: #c0392b;
        }
        main {
            margin-left: 240px;
            padding: 100px 40px 40px;
            min-height: 100vh;
            background: #240048;
            border-radius: 20px 0 0 20px;
            box-shadow: inset 0 0 100px #3a0071;
        }
        h1 {
            font-weight: 700;
            margin-bottom: 30px;
            color: #00ffe7;
            font-size: 2rem;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgb(0 0 0 / 0.3);
            background: #3b0062;
            color: #e3e3e3;
            font-size: 1rem;
        }
        thead tr {
            background: #5f009f;
            text-align: left;
            font-weight: 700;
            font-size: 1.1rem;
        }
        th, td {
            padding: 14px 20px;
        }
        tbody tr {
            border-bottom: 1px solid #5f009f;
            transition: background 0.3s ease;
        }
        tbody tr:hover {
            background: #601098;
            cursor: pointer;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        .action a {
            padding: 6px 14px;
            margin-right: 8px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
            color: #f5f5f5;
            display: inline-block;
        }
        .btn-edit {
            background-color: #3498db;
        }
        .btn-edit:hover {
            background-color: #2c80b4;
        }
        .btn-delete {
            background-color: #e74c3c;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .btn-add {
            background: #00d1ff;
            padding: 12px 22px;
            border-radius: 30px;
            font-weight: 700;
            color: #1b0036;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }
        .btn-add:hover {
            background: #00b5e2;
        }

        /* Search form wrapper */
        form.search-form {
            margin-bottom: 30px;
            display: flex;
            justify-content: flex-start;
            gap: 10px;
        }
        form.search-form button {
            padding: 8px 22px;
            background: #00d1ff;
            border: none;
            border-radius: 30px;
            font-weight: 700;
            color: #1b0036;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        form.search-form button:hover {
            background: #00b5e2;
        }
        form.search-form a.reset-btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 30px;
            background: #8e24aa;
            color: white;
            text-decoration: none;
            font-weight: 700;
            line-height: 36px;
            transition: background 0.3s ease;
        }
        form.search-form a.reset-btn:hover {
            background: #7b1fa2;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="../dashboard.php"><i class="fa fa-chart-line"></i> Dashboard</a>
        <a href="daftar.php" class="active"><i class="fa fa-user-graduate"></i> Data Mahasiswa</a>
        <a href="../blog/index.php"><i class="fa fa-newspaper"></i> Artikel Blog</a>
    </div>

    <div class="topbar">
        <form class="search-box" method="get" action="">
            <input type="text" name="search" placeholder="Cari nama atau email..." value="<?= htmlspecialchars($keyword) ?>" autofocus />
        </form>
        <div class="user-info">
            👋 <?= htmlspecialchars($_SESSION['user']['nama_lengkap'] ?? $_SESSION['user']['username']) ?>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <main>
        <h1>Daftar Biodata Mahasiswa</h1>

        <a href="tambah.php" class="btn-add">➕ Tambah Biodata</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data): $no = 1; foreach ($data as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['alamat'])) ?></td>
                    <td class="action">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit"><i class="fa fa-pen"></i> Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 20px; color: #f0a;">
                        Data tidak ditemukan.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
