<?php
// Ambil dari ENV, fallback hanya untuk local dev
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db   = getenv('DB_NAME') ?: 'ujian_web';

// 🚨 Cegah fallback 'localhost' di Railway
if (php_sapi_name() !== 'cli' && $_SERVER['SERVER_NAME'] !== 'localhost' && $host === 'localhost') {
    die("❌ ENV 'DB_HOST' tidak diset dengan benar. Hosting seperti Railway tidak bisa pakai 'localhost'.");
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
