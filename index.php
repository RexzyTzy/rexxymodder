<?php
session_start();
require_once 'config.php';

// Password encrypted dengan password_hash
$correct_password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], $correct_password_hash)) {
        $_SESSION['user_logged_in'] = true;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share MonetLoader SAMP by Rexxy</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-box {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .login-box h1 {
            color: #00d4ff;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .login-box p {
            color: #aaa;
            margin-bottom: 30px;
        }
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 16px;
            box-sizing: border-box;
        }
        .login-box input::placeholder {
            color: #888;
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            background: #00d4ff;
            border: none;
            border-radius: 8px;
            color: #1a1a2e;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-box button:hover {
            background: #00a8cc;
            transform: translateY(-2px);
        }
        .error {
            color: #ff6b6b;
            margin-top: 10px;
        }
        .logo {
            font-size: 60px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">🔒</div>
        <h1>Share MonetLoader SAMP</h1>
        <p>by Rexxy</p>
        <form method="POST">
            <input type="password" name="password" placeholder="Masukkan Password..." required>
            <button type="submit">Masuk</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
