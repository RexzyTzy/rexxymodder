<?php
session_start();
require_once '../config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header('Location: dashboard.php');
            exit;
        }
    }
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MonetLoader</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="admin-login">
    <div class="admin-box">
        <h2>🔐 Admin Panel</h2>
        <?php if (isset($error)) echo "<p style='color:#ff6b6b;text-align:center;margin-bottom:15px;'>$error</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="submit-btn">Login</button>
        </form>
        <p style="text-align:center; margin-top:20px; color:#666;">
            Belum punya akun? <a href="regis.php" style="color:#00d4ff;">Register</a>
        </p>
    </div>
</body>
</html>
