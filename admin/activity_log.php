<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 50;
$offset = ($page - 1) * $per_page;

$total = $conn->query("SELECT COUNT(*) as total FROM activity_log")->fetch_assoc()['total'];
$total_pages = ceil($total / $per_page);

$result = $conn->query("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT $per_page OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Activity Log - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active');document.querySelector('.sidebar-overlay').classList.toggle('active');">☰</div>
    <div class="sidebar-overlay" onclick="document.querySelector('.sidebar').classList.remove('active');this.classList.remove('active');"></div>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>⚙️ Admin Panel</h2>
            <p><?php echo $_SESSION['admin_username']; ?></p>
        </div>
        <ul class="menu">
            <li><a href="dashboard.php"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="add_monetloader.php"><span class="icon">➕</span> Add MonetLoader</a></li>
            <li><a href="manage_requests.php"><span class="icon">📨</span> Requests</a></li>
            <li><a href="manage_reports.php"><span class="icon">🐛</span> Reports</a></li>
            <li><a href="activity_log.php" class="active"><span class="icon">📊</span> Activity Log</a></li>
            <div class="menu-divider"></div>
            <li><a href="../home.php"><span class="icon">🌐</span> Ke Website</a></li>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="admin-header-bar">
            <h1>📊 Activity Log</h1>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>

        <div class="content-box">
            <p style="color:var(--text-secondary);margin-bottom:20px;">Total aktivitas: <?php echo $total; ?> records</p>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>ID</th><th>Waktu</th><th>User</th><th>Aksi</th><th>IP Address</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo date('d M Y H:i:s', strtotime($row['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($row['user_name'] ?? 'Guest'); ?></td>
                            <td><?php echo htmlspecialchars($row['action']); ?></td>
                            <td><code style="font-size:12px;background:rgba(0,212,255,0.1);padding:3px 8px;border-radius:4px;"><?php echo $row['ip_address']; ?></code></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $page): ?>
                <span class="active"><?php echo $i; ?></span>
                <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
