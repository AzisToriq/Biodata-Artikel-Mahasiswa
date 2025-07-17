<?php
require_once 'includes/koneksi.php';

$sql = file_get_contents('sql/DATABASE ujian_web.sql');
$pdo->exec($sql);

echo "Import berhasil!";
?>
