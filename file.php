<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
require_once 'config.php';

// Pagination
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 9;
$offset = ($page - 1) * $per_page;

// Filter
$filter_type = isset($_GET['type']) ? $_GET['type'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$where = [];
$params = [];
$types = '';

if ($filter_type) {
    $where[] = "file_type = ?";
    $params[] = $filter_type;
    $types .= 's';
}
if ($search) {
    $where[] = "(nama_file LIKE ? OR fungsi LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= 'ss';
}

$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Count total
$count_sql = "SELECT COUNT(*) as total FROM monetloader $where_sql";
if ($types) {
    $stmt = $conn->prepare($count_sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];
} else {
    $total = $conn->query($count_sql)->fetch_assoc()['total'];
}

$total_pages = ceil($total / $per_page);

// Get files
$sql = "SELECT * FROM monetloader $where_sql ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= 'ii';

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>File - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="file.php" class="active"><span class="icon">📁</span> File</a></li>
            <li><a href="preview.php"><span class="icon">👁️</span> Preview</a></li>
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
            <h1>📁 Daftar File MonetLoader</h1>
            <div class="header-actions">
                <a href="?type=PC" class="btn btn-sm <?php echo $filter_type=='PC'?'btn-primary':'btn-secondary'; ?>">💻 PC</a>
                <a href="?type=Android" class="btn btn-sm <?php echo $filter_type=='Android'?'btn-primary':'btn-secondary'; ?>">📱 Android</a>
                <a href="file.php" class="btn btn-sm btn-secondary">🔄 Reset</a>
            </div>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>File</span>
            <?php if ($filter_type): ?>
            <span>/</span>
            <span><?php echo $filter_type; ?></span>
            <?php endif; ?>
        </div>

        <!-- Search -->
        <div class="content-box" style="padding:20px;">
            <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;">
                <div class="search-box" style="flex:1;min-width:200px;">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" placeholder="Cari file..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <?php if ($filter_type): ?>
                <input type="hidden" name="type" value="<?php echo $filter_type; ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <!-- File Grid -->
        <?php if ($result->num_rows > 0): ?>
        <div class="file-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="file-card animate-fade">
                <div class="file-header">
                    <div class="file-icon">📄</div>
                    <h3><?php echo htmlspecialchars($row['nama_file']); ?></h3>
                </div>
                <div class="file-body">
                    <table class="file-details">
                        <tr>
                            <td>Size</td>
                            <td><?php echo htmlspecialchars($row['size']); ?></td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td><span class="badge badge-<?php echo strtolower($row['file_type']); ?>"><?php echo $row['file_type']; ?></span></td>
                        </tr>
                        <tr>
                            <td>Fungsi</td>
                            <td><?php echo nl2br(htmlspecialchars($row['fungsi'])); ?></td>
                        </tr>
                        <tr>
                            <td>CMD</td>
                            <td><code style="background:rgba(0,212,255,0.1);padding:2px 6px;border-radius:4px;color:var(--primary);font-size:12px;"><?php echo nl2br(htmlspecialchars(substr($row['cmd_cara'], 0, 50))); ?>...</code></td>
                        </tr>
                        <tr>
                            <td>Preview</td>
                            <td><a href="preview.php?id=<?php echo $row['id']; ?>" class="link-btn">👁️ Lihat Preview</a></td>
                        </tr>
                        <tr>
                            <td>Share By</td>
                            <td>👤 <?php echo htmlspecialchars($row['share_by']); ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>📅 <?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="file-footer">
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="btn btn-primary" download>
                        ⬇️ Download
                    </a>
                    <a href="tutorial.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary">
                        📖 Tutorial
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page-1; ?><?php echo $filter_type?'&type='.$filter_type:''; ?><?php echo $search?'&search='.urlencode($search):''; ?>">← Prev</a>
            <?php endif; ?>

            <?php for ($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++): ?>
            <?php if ($i == $page): ?>
            <span class="active"><?php echo $i; ?></span>
            <?php else: ?>
            <a href="?page=<?php echo $i; ?><?php echo $filter_type?'&type='.$filter_type:''; ?><?php echo $search?'&search='.urlencode($search):''; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page+1; ?><?php echo $filter_type?'&type='.$filter_type:''; ?><?php echo $search?'&search='.urlencode($search):''; ?>">Next →</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="empty-state animate-fade">
            <div class="empty-icon">📭</div>
            <h3>Belum ada file</h3>
            <p>File monetloader belum tersedia. Silakan request file yang Anda butuhkan.</p>
            <a href="request.php" class="btn btn-primary" style="margin-top:20px;">📨 Request File</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
