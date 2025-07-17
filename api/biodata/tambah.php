<?php
session_start();
require_once '../includes/koneksi.php';
if (!isset($_SESSION['user'])) {
  header("Location: ../auth/login.php");
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
    $stmt = $pdo->prepare("INSERT INTO biodata (nama, email, jenis_kelamin, alamat) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama, $email, $jenis_kelamin, $alamat]);
    header("Location: daftar.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Biodata</title>
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
    .container {
      margin: 80px auto;
      max-width: 600px;
      background: #2a0047;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.4);
    }
    h2 {
      text-align: center;
      color: #00d1ff;
      margin-bottom: 30px;
    }
    label {
      display: block;
      margin-top: 20px;
      font-weight: bold;
    }
    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border: none;
      border-radius: 10px;
      background: #320058;
      color: white;
    }
    input:focus, select:focus, textarea:focus {
      outline: 2px solid #00ffe7;
    }
    .submit-btn {
      margin-top: 30px;
      background: #00d1ff;
      color: black;
      font-weight: bold;
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
    }
    .submit-btn:hover {
      background: #00ffe7;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #aaa;
      text-decoration: none;
    }
    .back-link:hover {
      color: #fff;
    }
    .error-msg {
      background: #e74c3c;
      color: white;
      padding: 12px;
      border-radius: 10px;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Tambah Biodata Mahasiswa</h2>

    <?php if($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="nama">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />

      <label for="jenis_kelamin">Jenis Kelamin</label>
      <select name="jenis_kelamin" id="jenis_kelamin" required>
        <option value="" disabled <?= empty($_POST['jenis_kelamin']) ? 'selected' : '' ?>>-- Pilih --</option>
        <option value="Laki-laki" <?= (($_POST['jenis_kelamin'] ?? '') === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
        <option value="Perempuan" <?= (($_POST['jenis_kelamin'] ?? '') === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
      </select>

      <label for="alamat">Alamat</label>
      <textarea id="alamat" name="alamat" rows="4" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>

      <button type="submit" class="submit-btn">Simpan Biodata</button>
    </form>
    <a href="daftar.php" class="back-link">⬅️ Kembali ke Daftar Biodata</a>
  </div>
</body>
</html>
