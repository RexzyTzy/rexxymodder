<?php
// Database Configuration - Share MonetLoader SAMP by Rexxy
// Host: 51.83.49.125:3306
// Database: s174775_rexxy

define('DB_HOST', '51.83.49.125:3306');
define('DB_USER', 'u174775_77g2SLPAdI');
define('DB_PASS', 'i+Ut4wB1QSL+yxWUGkrvU=NU');
define('DB_NAME', 's174775_rexxy');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

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

// Tabel request file
$conn->query("CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    request_text TEXT NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Tabel report bug
$conn->query("CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    bug_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('open','in_progress','resolved','closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Tabel activity log
$conn->query("CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100),
    action VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>
