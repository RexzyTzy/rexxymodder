<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="tutorial.php" class="active">📖 Tutorial</a></li>
            <li><a href="credits.php">⭐ Credits</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>📖 Tutorial Penggunaan MonetLoader</h1>
        </div>

        <div class="tutorial-list">
            <?php
            $result = $conn->query("SELECT * FROM monetloader WHERE cmd_cara != '' ORDER BY created_at DESC");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <div class="tutorial-card">
                <h3>📄 <?php echo htmlspecialchars($row['nama_file']); ?></h3>
                <table class="file-details">
                    <tr>
                        <td><strong>NAMA FILE</strong></td>
                        <td>: <?php echo htmlspecialchars($row['nama_file']); ?></td>
                    </tr>
                </table>
                <div class="tutorial-content">
                    <h4>📝 CMD / Cara Pakai:</h4>
                    <div class="cmd-box">
                        <?php echo nl2br(htmlspecialchars($row['cmd_cara'])); ?>
                    </div>

                    <?php if ($row['preview_path']): ?>
                    <h4>🎥 Video Tutorial:</h4>
                    <div class="video-container">
                        <?php 
                        $ext = strtolower(pathinfo($row['preview_path'], PATHINFO_EXTENSION));
                        if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                        ?>
                            <video controls width="100%">
                                <source src="<?php echo htmlspecialchars($row['preview_path']); ?>" type="video/<?php echo $ext; ?>">
                            </video>
                        <?php } ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<div class='empty'>Belum ada tutorial tersedia.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
