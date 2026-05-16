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
    <title>Home - Share MonetLoader SAMP by Rexxy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>📥 MonetLoader</h2>
            <p>by Rexxy</p>
        </div>
        <ul class="menu">
            <li><a href="home.php" class="active">🏠 Home</a></li>
            <li><a href="file.php">📁 File</a></li>
            <li><a href="preview.php">👁️ Preview</a></li>
            <li><a href="tutorial.php">📖 Tutorial</a></li>
            <li><a href="credits.php">⭐ Credits</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Selamat Datang di Share MonetLoader SAMP</h1>
        </div>

        <div class="content-box">
            <h2>📌 Tentang Website Ini</h2>
            <p>Website ini adalah platform untuk berbagi dan mengunduh MonetLoader untuk GTA SAMP.</p>
            <p>MonetLoader adalah tools/scripts yang digunakan untuk memudahkan gameplay di GTA San Andreas Multiplayer.</p>

            <h3>🎯 Fitur Utama:</h3>
            <ul>
                <li>📁 Download berbagai MonetLoader</li>
                <li>👁️ Preview file sebelum download</li>
                <li>📖 Tutorial penggunaan lengkap</li>
                <li>⭐ Credits untuk tim pengembang</li>
            </ul>

            <h3>⚠️ Perhatian:</h3>
            <p>Gunakan MonetLoader dengan bijak. Kami tidak bertanggung jawab atas banned akun.</p>

            <div class="stats">
                <div class="stat-card">
                    <h3>Total File</h3>
                    <?php
                    require_once 'config.php';
                    $result = $conn->query("SELECT COUNT(*) as total FROM monetloader");
                    $row = $result->fetch_assoc();
                    echo "<p>" . $row['total'] . "</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
