<?php
session_start();
require_once '../config.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $success = "Registrasi berhasil! Silakan login.";
    } else {
        $error = "Username sudah digunakan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin - MonetLoader</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="admin-login">
    <div class="admin-box">
        <h2>📝 Register Admin</h2>
        <?php 
        if (isset($success)) echo "<p style='color:#00ff88;text-align:center;margin-bottom:15px;'>$success</p>";
        if (isset($error)) echo "<p style='color:#ff6b6b;text-align:center;margin-bottom:15px;'>$error</p>";
        ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="register" class="submit-btn">Register</button>
        </form>
        <p style="text-align:center; margin-top:20px; color:#666;">
            Sudah punya akun? <a href="adm.php" style="color:#00d4ff;">Login</a>
        </p>
    </div>
</body>
</html>
