<?php
session_start();
require_once '../includes/koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (!$username || !$nama_lengkap || !$password || !$password_confirm) {
        $error = "Semua field wajib diisi!";
    } elseif ($password !== $password_confirm) {
        $error = "Password dan konfirmasi password tidak sama!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Username sudah dipakai, coba yang lain.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (username, nama_lengkap, password_hash) VALUES (?, ?, ?)");
            $insert->execute([$username, $nama_lengkap, $password_hash]);
            $success = "Registrasi berhasil! Silakan <a href='login.php'>login di sini</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Register - Blog Mahasiswa</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }
        .form-container {
            background: #2a0047;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            color: #00d1ff;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 0 0 8px #00d1ffaa;
            font-size: 28px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 22px;
            border: 1.5px solid #555;
            border-radius: 10px;
            background: #1e0033;
            color: #f5f5f5;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #00d1ff;
            outline: none;
            box-shadow: 0 0 8px #00d1ffcc;
            background: #330066;
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #00d1ff;
            color: #1e0033;
            font-size: 18px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 0 10px #00d1ffbb;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        button:hover {
            background-color: #008ecc;
            color: #e0f7ff;
            box-shadow: 0 0 14px #008ecccc;
        }
        .error {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 0 0 4px #e74c3caa;
        }
        .success {
            color: #2ecc71;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 0 0 6px #2ecc71cc;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
            color: #b3b3b3;
        }
        a {
            color: #00d1ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a:hover {
            text-decoration: underline;
            color: #008ecc;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 30px 25px;
            }
            h2 {
                font-size: 24px;
            }
            button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" />
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? '') ?>" />
            <input type="password" name="password" placeholder="Password" required />
            <input type="password" name="password_confirm" placeholder="Konfirmasi Password" required />
            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>
