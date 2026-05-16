<?php
// Railway.com Database Configuration
// Menggunakan environment variables dari Railway

$db_host = getenv('MYSQLHOST') ?: '51.83.49.125:3306';
$db_user = getenv('MYSQLUSER') ?: 'u174775_77g2SLPAdI';
$db_pass = getenv('MYSQLPASSWORD') ?: 'i+Ut4wB1QSL+yxWUGkrvU=NU';
$db_name = getenv('MYSQLDATABASE') ?: 's174775_rexxy';

// Railway format: mysql://user:pass@host:port/database
$mysql_url = getenv('MYSQL_URL');
if ($mysql_url) {
    $parsed = parse_url($mysql_url);
    $db_host = $parsed['host'] . ':' . ($parsed['port'] ?? '3306');
    $db_user = $parsed['user'];
    $db_pass = $parsed['pass'];
    $db_name = ltrim($parsed['path'], '/');
}

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Buat tabel jika belum ada
$conn->query("CREATE TABLE IF NOT EXISTS monetloader (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_file VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    size VARCHAR(50) NOT NULL,
    file_type ENUM('PC','Android') NOT NULL,
    fungsi TEXT NOT NULL,
    cmd_cara TEXT NOT NULL,
    preview_path VARCHAR(500),
    share_by VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>
