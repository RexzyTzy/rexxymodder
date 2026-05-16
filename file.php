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
    <title>File - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="file.php" class="active">📁 File</a></li>
            <li><a href="preview.php">👁️ Preview</a></li>
            <li><a href="tutorial.php">📖 Tutorial</a></li>
            <li><a href="credits.php">⭐ Credits</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>📁 Daftar File MonetLoader</h1>
        </div>

        <div class="file-list">
            <?php
            $result = $conn->query("SELECT * FROM monetloader ORDER BY created_at DESC");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <div class="file-card">
                <div class="file-info">
                    <h3>📄 <?php echo htmlspecialchars($row['nama_file']); ?></h3>
                    <table class="file-details">
                        <tr>
                            <td><strong>NAMA FILE</strong></td>
                            <td>: <?php echo htmlspecialchars($row['nama_file']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>SIZE</strong></td>
                            <td>: <?php echo htmlspecialchars($row['size']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>FILE PC/ANDRO</strong></td>
                            <td>: <?php echo htmlspecialchars($row['file_type']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>FUNGSI</strong></td>
                            <td>: <?php echo nl2br(htmlspecialchars($row['fungsi'])); ?></td>
                        </tr>
                        <tr>
                            <td><strong>CMD/CARA PAKAI</strong></td>
                            <td>: <?php echo nl2br(htmlspecialchars($row['cmd_cara'])); ?></td>
                        </tr>
                        <tr>
                            <td><strong>PREVIEW</strong></td>
                            <td>: <a href="preview.php?id=<?php echo $row['id']; ?>" class="link-btn">Lihat Preview</a></td>
                        </tr>
                        <tr>
                            <td><strong>SHARE BY</strong></td>
                            <td>: <?php echo htmlspecialchars($row['share_by']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="file-actions">
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="download-btn" download>
                        ⬇️ Download File
                    </a>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<div class='empty'>Belum ada file tersedia.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
