<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
require_once 'config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tutorial - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="tutorial.php" class="active"><span class="icon">📖</span> Tutorial</a></li>
            <li><a href="credits.php"><span class="icon">⭐</span> Credits</a></li>
            <div class="menu-divider"></div>
            <li><a href="request.php"><span class="icon">📨</span> Request File</a></li>
            <li><a href="report.php"><span class="icon">🐛</span> Report Bug</a></li>
            <div class="menu-divider"></div>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>📖 Tutorial Penggunaan</h1>
            <div class="header-actions">
                <a href="file.php" class="btn btn-secondary btn-sm">📁 Lihat File</a>
            </div>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>Tutorial</span>
        </div>

        <div class="tutorial-list">
            <?php
            if ($id > 0) {
                $stmt = $conn->prepare("SELECT * FROM monetloader WHERE id = ? AND cmd_cara != ''");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $conn->query("SELECT * FROM monetloader WHERE cmd_cara != '' ORDER BY created_at DESC");
            }

            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
            ?>
            <div class="tutorial-card animate-fade">
                <div class="tutorial-header">
                    <div class="tutorial-number"><?php echo $no++; ?></div>
                    <div>
                        <div class="tutorial-title"><?php echo htmlspecialchars($row['nama_file']); ?></div>
                        <p style="color:var(--text-secondary);font-size:13px;margin-top:4px;">
                            <span class="badge badge-<?php echo strtolower($row['file_type']); ?>"><?php echo $row['file_type']; ?></span>
                            • <?php echo $row['size']; ?>
                            • Share by <?php echo htmlspecialchars($row['share_by']); ?>
                        </p>
                    </div>
                </div>

                <h4 style="color:var(--accent);margin-bottom:10px;">📝 CMD / Cara Pakai:</h4>
                <div class="cmd-box">
                    <pre><?php echo htmlspecialchars($row['cmd_cara']); ?></pre>
                </div>

                <h4 style="color:var(--accent);margin:20px 0 10px;">📋 Fungsi:</h4>
                <p style="color:var(--text-secondary);line-height:1.8;"><?php echo nl2br(htmlspecialchars($row['fungsi'])); ?></p>

                <?php if ($row['preview_path']): ?>
                <h4 style="color:var(--accent);margin:20px 0 10px;">🎥 Video Tutorial:</h4>
                <div class="video-container" style="border-radius:var(--radius);overflow:hidden;margin-top:10px;">
                    <?php 
                    $ext = strtolower(pathinfo($row['preview_path'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                    ?>
                        <video controls width="100%" style="max-height:400px;">
                            <source src="<?php echo htmlspecialchars($row['preview_path']); ?>" type="video/<?php echo $ext; ?>">
                        </video>
                    <?php } else { ?>
                        <img src="<?php echo htmlspecialchars($row['preview_path']); ?>" alt="Tutorial" style="max-width:100%;border-radius:var(--radius-sm);">
                    <?php } ?>
                </div>
                <?php endif; ?>

                <div style="margin-top:25px;display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-primary" download>⬇️ Download File</a>
                    <a href="preview.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">👁️ Preview</a>
                </div>
            </div>
            <?php
                }
            } else {
            ?>
            <div class="empty-state animate-fade">
                <div class="empty-icon">📚</div>
                <h3>Belum ada tutorial</h3>
                <p>Tutorial penggunaan belum tersedia untuk file ini.</p>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
