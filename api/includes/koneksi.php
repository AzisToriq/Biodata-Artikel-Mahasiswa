<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // sesuaikan dengan XAMPP kamu
$db = 'ujian_web';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
