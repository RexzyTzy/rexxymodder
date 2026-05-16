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
    <title>Preview - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="preview.php" class="active">👁️ Preview</a></li>
            <li><a href="tutorial.php">📖 Tutorial</a></li>
            <li><a href="credits.php">⭐ Credits</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>👁️ Preview MonetLoader</h1>
        </div>

        <div class="preview-list">
            <?php
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $stmt = $conn->prepare("SELECT * FROM monetloader WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
            ?>
            <div class="preview-card">
                <h3>📄 <?php echo htmlspecialchars($row['nama_file']); ?></h3>
                <table class="file-details">
                    <tr>
                        <td><strong>NAMA FILE</strong></td>
                        <td>: <?php echo htmlspecialchars($row['nama_file']); ?></td>
                    </tr>
                </table>
                <div class="preview-media">
                    <?php if ($row['preview_path']): ?>
                        <?php 
                        $ext = strtolower(pathinfo($row['preview_path'], PATHINFO_EXTENSION));
                        if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                        ?>
                            <video controls width="100%">
                                <source src="<?php echo htmlspecialchars($row['preview_path']); ?>" type="video/<?php echo $ext; ?>">
                                Browser tidak support video.
                            </video>
                        <?php } else { ?>
                            <img src="<?php echo htmlspecialchars($row['preview_path']); ?>" alt="Preview" style="max-width:100%; border-radius:10px;">
                        <?php } ?>
                    <?php else: ?>
                        <p>Tidak ada preview tersedia.</p>
                    <?php endif; ?>
                </div>
                <a href="file.php" class="back-btn">← Kembali ke File</a>
            </div>
            <?php
                }
            } else {
                $result = $conn->query("SELECT * FROM monetloader WHERE preview_path IS NOT NULL ORDER BY created_at DESC");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>
            <div class="preview-card">
                <h3>📄 <?php echo htmlspecialchars($row['nama_file']); ?></h3>
                <table class="file-details">
                    <tr>
                        <td><strong>NAMA FILE</strong></td>
                        <td>: <?php echo htmlspecialchars($row['nama_file']); ?></td>
                    </tr>
                </table>
                <div class="preview-media">
                    <?php 
                    $ext = strtolower(pathinfo($row['preview_path'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                    ?>
                        <video controls width="100%">
                            <source src="<?php echo htmlspecialchars($row['preview_path']); ?>" type="video/<?php echo $ext; ?>">
                        </video>
                    <?php } else { ?>
                        <img src="<?php echo htmlspecialchars($row['preview_path']); ?>" alt="Preview" style="max-width:100%; border-radius:10px;">
                    <?php } ?>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo "<div class='empty'>Belum ada preview tersedia.</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
