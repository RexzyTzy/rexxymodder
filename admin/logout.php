<?php
session_start();
require_once '../config.php';

if (isset($_SESSION['admin_username'])) {
    $user = $_SESSION['admin_username'];
    $conn->query("INSERT INTO activity_log (user_name, action, ip_address) VALUES ('$user', 'Admin logout', '{$_SERVER['REMOTE_ADDR']}')");
}

session_destroy();
header('Location: adm.php');
exit;
?>
