<?php 
session_start();
require_once '../includes/koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'] ?? $user['username'],
        ];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Blog Mahasiswa</title>
    <style>
        /* Reset & base */
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
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background: #300048;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.6);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #00d1ff;
            text-shadow: 0 0 8px #00d1ffbb;
            font-weight: 700;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            background-color: #46007a;
            color: #ddd;
            box-shadow: inset 0 0 8px #7200b6;
            transition: background-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            background-color: #5a0099;
            outline: none;
            box-shadow: 0 0 10px #00d1ff;
            color: #fff;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #00d1ff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 700;
            color: #1e0033;
            cursor: pointer;
            box-shadow: 0 0 20px #00d1ffaa;
            transition: background-color 0.3s ease, box-shadow 0.4s ease;
        }

        button:hover {
            background-color: #00a8cc;
            box-shadow: 0 0 25px #00a8ccff;
        }

        .error {
            background-color: #e74c3c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 0 4px #b71c1c;
        }

        p.register-link {
            margin-top: 20px;
            font-size: 15px;
            color: #a0a0a0;
        }

        p.register-link a {
            color: #00d1ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        p.register-link a:hover {
            color: #00a8cc;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            h2 {
                font-size: 24px;
            }
            button {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 Login Blog Mahasiswa</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required autocomplete="username" />
            <input type="password" name="password" placeholder="Password" required autocomplete="current-password" />
            <button type="submit">Masuk</button>
        </form>

        <p class="register-link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
