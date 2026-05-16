<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credits - Share MonetLoader SAMP by Rexxy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>📥 MonetLoader</h2>
            <p>by Rexxy</p>
        </div>
        <ul class="menu">
            <li><a href="home.php">🏠 Home</a></li>
            <li><a href="file.php">📁 File</a></li>
            <li><a href="preview.php">👁️ Preview</a></li>
            <li><a href="tutorial.php">📖 Tutorial</a></li>
            <li><a href="credits.php" class="active">⭐ Credits</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>⭐ Credits Team</h1>
        </div>

        <div class="credits-container">
            <div class="credit-card owner">
                <div class="avatar">👑</div>
                <h3>Rexxy</h3>
                <span class="role">OWNER</span>
                <p>Pembuat Website</p>
            </div>

            <div class="credit-card">
                <div class="avatar">🤝</div>
                <h3>Noah</h3>
                <span class="role">PARTNER</span>
                <p>Pembuat MonetLoader</p>
            </div>

            <div class="credit-card">
                <div class="avatar">📢</div>
                <h3>Lax</h3>
                <span class="role">PARTNER</span>
                <p>Tukang Share MonetLoader</p>
            </div>

            <div class="credit-card">
                <div class="avatar">📚</div>
                <h3>Bob</h3>
                <span class="role">PARTNER</span>
                <p>Tukang Tutorial Pakai MonetLoader</p>
            </div>
        </div>
    </div>
</body>
</html>
