<?php
// Ambil data dari ENV (sesuai Railway), fallback ke local dev
$host = getenv('DB_HOST') ?: 'yamabiko.proxy.rlwy.net';
$port = getenv('DB_PORT') ?: '51213';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: 'isi_password_railway'; // Ganti dengan password aslinya
$db   = getenv('DB_NAME') ?: 'railway';

// 🚨 Validasi biar gak connect ke localhost di production
if (php_sapi_name() !== 'cli' && $_SERVER['SERVER_NAME'] !== 'localhost' && $host === 'localhost') {
    die("❌ ENV 'DB_HOST' tidak diset dengan benar. Hosting seperti Railway tidak bisa pakai 'localhost'.");
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Koneksi gagal: " . $e->getMessage());
}
?>
