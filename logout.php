<?php
session_start();
require_once 'config.php';

// Log logout activity
if (isset($_SESSION['user_name'])) {
    $user = $_SESSION['user_name'];
    $conn->query("INSERT INTO activity_log (user_name, action, ip_address) VALUES ('$user', 'User logout', '{$_SERVER['REMOTE_ADDR']}')");
}

session_destroy();
header('Location: index.php');
exit;
?>
