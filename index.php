<?php
session_start();
require_once 'config.php';

// Password tanpa encrypt
$correct_password = 'rexxyXnoah';

if (isset($_POST['password'])) {
    if ($_POST['password'] === $correct_password) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_name'] = 'Member';
        header('Location: home.php');
        exit;
    } else {
        $error = "Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Share MonetLoader SAMP by Rexxy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <div class="login-box animate-fade">
        <div class="logo-icon">🔐</div>
        <h1>Share MonetLoader</h1>
        <p class="subtitle">SAMP by Rexxy</p>
        <form method="POST">
            <input type="password" name="password" placeholder="Masukkan Password..." required autocomplete="off">
            <button type="submit">🔓 Masuk ke Website</button>
        </form>
        <?php if (isset($error)) echo "<div class='alert alert-error' style='margin-top:15px;'>❌ $error</div>"; ?>
        <div class="login-footer">
            <p>🔒 Website Private • Rexxy & Team</p>
        </div>
    </div>
</body>
</html>
