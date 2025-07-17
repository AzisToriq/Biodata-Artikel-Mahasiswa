<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}

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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($artikel['judul']) ?> - Detail Artikel</title>
    <link rel="stylesheet" href="../assets/style.css" />
     <link rel="stylesheet" href="assets/css/global.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($artikel['judul']) ?></h1>
        <small>Dipublikasikan: <?= htmlspecialchars($artikel['tanggal']) ?></small>
        <p><?= nl2br(htmlspecialchars($artikel['konten'])) ?></p>

        <a href="index.php" class="back-link">⬅️ Kembali ke Daftar Artikel</a>
       

    </div>
</body>
</html>
