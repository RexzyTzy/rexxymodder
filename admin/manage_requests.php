<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';

// Update status
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    if (in_array($action, ['approved', 'rejected'])) {
        $conn->query("UPDATE requests SET status='$action' WHERE id=$id");
    }
    header('Location: manage_requests.php');
    exit;
}

// Get all requests
$result = $conn->query("SELECT * FROM requests ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manage Requests - Admin</title>
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
            <li><a href="manage_requests.php" class="active"><span class="icon">📨</span> Requests</a></li>
            <li><a href="manage_reports.php"><span class="icon">🐛</span> Reports</a></li>
            <li><a href="activity_log.php"><span class="icon">📊</span> Activity Log</a></li>
            <div class="menu-divider"></div>
            <li><a href="../home.php"><span class="icon">🌐</span> Ke Website</a></li>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="admin-header-bar">
            <h1>📨 Manage Requests</h1>
            <a href="dashboard.php" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>

        <div class="content-box">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>ID</th><th>User</th><th>Request</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['request_text'])); ?></td>
                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                <span style="color:var(--warning);">⏳ Pending</span>
                                <?php elseif ($row['status'] == 'approved'): ?>
                                <span style="color:var(--success);">✅ Approved</span>
                                <?php else: ?>
                                <span style="color:var(--danger);">❌ Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                <a href="?action=approved&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">✅</a>
                                <a href="?action=rejected&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">❌</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
