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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Credits - Share MonetLoader SAMP by Rexxy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active');document.querySelector('.sidebar-overlay').classList.toggle('active');">☰</div>
    <div class="sidebar-overlay" onclick="document.querySelector('.sidebar').classList.remove('active');this.classList.remove('active');"></div>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>📥 MonetLoader</h2>
            <p>by Rexxy</p>
        </div>
        <div class="user-info">
            <div class="user-avatar">👤</div>
            <div class="user-details">
                <h4><?php echo $_SESSION['user_name'] ?? 'Member'; ?></h4>
                <span>User</span>
            </div>
        </div>
        <ul class="menu">
            <li><a href="home.php"><span class="icon">🏠</span> Home</a></li>
            <li><a href="file.php"><span class="icon">📁</span> File</a></li>
            <li><a href="preview.php"><span class="icon">👁️</span> Preview</a></li>
            <li><a href="tutorial.php"><span class="icon">📖</span> Tutorial</a></li>
            <li><a href="credits.php" class="active"><span class="icon">⭐</span> Credits</a></li>
            <div class="menu-divider"></div>
            <li><a href="request.php"><span class="icon">📨</span> Request File</a></li>
            <li><a href="report.php"><span class="icon">🐛</span> Report Bug</a></li>
            <div class="menu-divider"></div>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>⭐ Credits Team</h1>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>Credits</span>
        </div>

        <div class="content-box animate-fade" style="text-align:center;margin-bottom:30px;">
            <h2>🤝 Tim Pengembang</h2>
            <p style="color:var(--text-secondary);max-width:600px;margin:15px auto 0;">
                Terima kasih kepada tim yang telah berkontribusi dalam pengembangan website dan monetloader ini.
            </p>
        </div>

        <div class="credits-grid">
            <div class="credit-card owner animate-fade">
                <div class="credit-avatar">👑</div>
                <h3>Rexxy</h3>
                <span class="credit-role">Owner</span>
                <p>Pembuat Website & Leader</p>
                <div class="social-links">
                    <a href="#" title="Discord">💬</a>
                    <a href="#" title="YouTube">📺</a>
                    <a href="#" title="Instagram">📸</a>
                </div>
            </div>

            <div class="credit-card animate-fade" style="animation-delay:0.1s">
                <div class="credit-avatar">🤝</div>
                <h3>Noah</h3>
                <span class="credit-role">Partner</span>
                <p>Pembuat MonetLoader</p>
                <div class="social-links">
                    <a href="#" title="Discord">💬</a>
                    <a href="#" title="GitHub">🐙</a>
                </div>
            </div>

            <div class="credit-card animate-fade" style="animation-delay:0.2s">
                <div class="credit-avatar">📢</div>
                <h3>Lax</h3>
                <span class="credit-role">Partner</span>
                <p>Tukang Share MonetLoader</p>
                <div class="social-links">
                    <a href="#" title="Discord">💬</a>
                    <a href="#" title="Telegram">✈️</a>
                </div>
            </div>

            <div class="credit-card animate-fade" style="animation-delay:0.3s">
                <div class="credit-avatar">📚</div>
                <h3>Bob</h3>
                <span class="credit-role">Partner</span>
                <p>Tukang Tutorial & Guide</p>
                <div class="social-links">
                    <a href="#" title="Discord">💬</a>
                    <a href="#" title="YouTube">📺</a>
                </div>
            </div>
        </div>

        <div class="content-box animate-fade" style="margin-top:30px;text-align:center;">
            <h3>🙏 Special Thanks</h3>
            <p style="color:var(--text-secondary);margin-top:10px;">
                Terima kasih kepada semua member yang telah menggunakan dan mensupport website ini.
                <br>Jangan lupa share ke teman-teman kalian! 🔥
            </p>
        </div>
    </div>
</body>
</html>
