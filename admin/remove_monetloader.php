<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';

$id = intval($_GET['id'] ?? 0);

// Ambil data untuk hapus file
$result = $conn->query("SELECT * FROM monetloader WHERE id = $id");
if ($row = $result->fetch_assoc()) {
    if (file_exists($row['file_path'])) unlink($row['file_path']);
    if (file_exists($row['preview_path'])) unlink($row['preview_path']);
}

$conn->query("DELETE FROM monetloader WHERE id = $id");

header('Location: dashboard.php');
exit;
?>
