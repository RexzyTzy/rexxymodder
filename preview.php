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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Preview - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="preview.php" class="active"><span class="icon">👁️</span> Preview</a></li>
            <li><a href="tutorial.php"><span class="icon">📖</span> Tutorial</a></li>
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
            <h1>👁️ Preview MonetLoader</h1>
            <div class="header-actions">
                <a href="file.php" class="btn btn-secondary btn-sm">← Kembali ke File</a>
            </div>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>Preview</span>
        </div>

        <div class="preview-grid">
            <?php
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $stmt = $conn->prepare("SELECT * FROM monetloader WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
            ?>
            <div class="preview-card animate-fade" style="grid-column:1/-1;">
                <div class="preview-info" style="padding:25px 30px;">
                    <h2 style="color:var(--primary);margin-bottom:10px;">📄 <?php echo htmlspecialchars($row['nama_file']); ?></h2>
                    <p style="color:var(--text-secondary);font-size:14px;">
                        <span class="badge badge-<?php echo strtolower($row['file_type']); ?>"><?php echo $row['file_type']; ?></span>
                        • <?php echo $row['size']; ?>
                        • Share by <?php echo htmlspecialchars($row['share_by']); ?>
                    </p>
                </div>
                <div class="preview-media" style="min-height:300px;">
                    <?php if ($row['preview_path']): ?>
                        <?php 
                        $ext = strtolower(pathinfo($row['preview_path'], PATHINFO_EXTENSION));
                        if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                        ?>
                            <video controls style="max-height:500px;width:100%;">
                                <source src="<?php echo htmlspecialchars($row['preview_path']); ?>" type="video/<?php echo $ext; ?>">
                                Browser tidak support video.
                            </video>
                        <?php } else { ?>
                            <img src="<?php echo htmlspecialchars($row['preview_path']); ?>" alt="Preview" style="max-height:500px;width:auto;max-width:100%;">
                        <?php } ?>
                    <?php else: ?>
                        <div class="empty-state" style="padding:40px;">
                            <div class="empty-icon">🖼️</div>
                            <h3>Tidak ada preview</h3>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="padding:20px 30px;display:flex;gap:10px;flex-wrap:wrap;">
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-primary" download>⬇️ Download File</a>
                    <a href="tutorial.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">📖 Lihat Tutorial</a>
                </div>
            </div>
            <?php
                }
            } else {
                $result = $conn->query("SELECT * FROM monetloader WHERE preview_path IS NOT NULL ORDER BY created_at DESC");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>
            <div class="preview-card animate-fade">
                <div class="preview-media" style="min-height:200px;">
                    <?php 
                    $ext = strtolower(pathinfo($row['preview_path'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['mp4', 'webm', 'mov'])) {
                    ?>
                        <video controls style="max-height:250px;width:100%;">
                            <source src="<?php echo htmlspecialchars($row['preview_path']); ?>" type="video/<?php echo $ext; ?>">
                        </video>
                    <?php } else { ?>
                        <img src="<?php echo htmlspecialchars($row['preview_path']); ?>" alt="Preview" style="max-height:250px;width:auto;max-width:100%;">
                    <?php } ?>
                </div>
                <div class="preview-info">
                    <h3 style="color:var(--primary);font-size:16px;margin-bottom:8px;">📄 <?php echo htmlspecialchars($row['nama_file']); ?></h3>
                    <p style="color:var(--text-secondary);font-size:13px;">
                        <span class="badge badge-<?php echo strtolower($row['file_type']); ?>"><?php echo $row['file_type']; ?></span>
                        • <?php echo $row['size']; ?>
                    </p>
                    <div style="margin-top:15px;display:flex;gap:8px;">
                        <a href="preview.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">👁️ Detail</a>
                        <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-sm btn-secondary" download>⬇️</a>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<div class="empty-state" style="grid-column:1/-1;"><div class="empty-icon">🖼️</div><h3>Belum ada preview</h3></div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
