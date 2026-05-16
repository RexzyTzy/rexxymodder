<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';

// Stats
$stats = $conn->query("SELECT 
    (SELECT COUNT(*) FROM monetloader) as total_files,
    (SELECT COUNT(*) FROM admin) as total_admins,
    (SELECT COUNT(*) FROM requests WHERE status='pending') as pending_requests,
    (SELECT COUNT(*) FROM reports WHERE status='open') as open_reports,
    (SELECT COUNT(*) FROM activity_log WHERE DATE(created_at) = CURDATE()) as today_activity
")->fetch_assoc();

// Get recent requests
$requests = $conn->query("SELECT * FROM requests ORDER BY created_at DESC LIMIT 5");

// Get recent reports
$reports = $conn->query("SELECT * FROM reports ORDER BY created_at DESC LIMIT 5");

// Get recent activity
$activities = $conn->query("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Dashboard - MonetLoader</title>
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
        <div class="user-info">
            <div class="user-avatar" style="background:linear-gradient(135deg, var(--accent), var(--warning));">👑</div>
            <div class="user-details">
                <h4><?php echo $_SESSION['admin_username']; ?></h4>
                <span class="badge badge-admin">Admin</span>
            </div>
        </div>
        <ul class="menu">
            <li><a href="dashboard.php" class="active"><span class="icon">🏠</span> Dashboard</a></li>
            <li><a href="add_monetloader.php"><span class="icon">➕</span> Add MonetLoader</a></li>
            <li><a href="manage_requests.php"><span class="icon">📨</span> Requests <?php if($stats['pending_requests']>0) echo '<span style="color:var(--danger);">('.$stats['pending_requests'].')</span>'; ?></a></li>
            <li><a href="manage_reports.php"><span class="icon">🐛</span> Reports <?php if($stats['open_reports']>0) echo '<span style="color:var(--danger);">('.$stats['open_reports'].')</span>'; ?></a></li>
            <li><a href="activity_log.php"><span class="icon">📊</span> Activity Log</a></li>
            <div class="menu-divider"></div>
            <li><a href="../home.php"><span class="icon">🌐</span> Ke Website</a></li>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="admin-header-bar">
            <h1>🏠 Admin Dashboard</h1>
            <a href="add_monetloader.php" class="btn btn-primary">➕ Tambah MonetLoader</a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card animate-fade">
                <div class="stat-icon">📦</div>
                <h3>Total Files</h3>
                <div class="value"><?php echo $stats['total_files']; ?></div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.1s">
                <div class="stat-icon">👑</div>
                <h3>Admins</h3>
                <div class="value"><?php echo $stats['total_admins']; ?></div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.2s">
                <div class="stat-icon">📨</div>
                <h3>Pending Requests</h3>
                <div class="value" style="color:<?php echo $stats['pending_requests']>0?'var(--danger)':'var(--primary)'; ?>"><?php echo $stats['pending_requests']; ?></div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.3s">
                <div class="stat-icon">🐛</div>
                <h3>Open Reports</h3>
                <div class="value" style="color:<?php echo $stats['open_reports']>0?'var(--danger)':'var(--primary)'; ?>"><?php echo $stats['open_reports']; ?></div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.4s">
                <div class="stat-icon">📊</div>
                <h3>Activity Today</h3>
                <div class="value"><?php echo $stats['today_activity']; ?></div>
            </div>
        </div>

        <!-- Files Table -->
        <div class="content-box animate-fade">
            <h2>📁 Daftar MonetLoader</h2>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>ID</th><th>Nama File</th><th>Size</th><th>Type</th><th>Share By</th><th>Tanggal</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $files = $conn->query("SELECT * FROM monetloader ORDER BY created_at DESC LIMIT 20");
                        while ($row = $files->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td>📄 <?php echo htmlspecialchars($row['nama_file']); ?></td>
                            <td><?php echo $row['size']; ?></td>
                            <td><span class="badge badge-<?php echo strtolower($row['file_type']); ?>"><?php echo $row['file_type']; ?></span></td>
                            <td><?php echo htmlspecialchars($row['share_by']); ?></td>
                            <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td class="action-btns">
                                <a href="edit_monetloader.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-secondary">✏️</a>
                                <a href="remove_monetloader.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus file ini?')">🗑️</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Requests & Reports -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(400px, 1fr));gap:25px;">
            <div class="content-box animate-fade">
                <h2>📨 Request Terbaru</h2>
                <?php if ($requests->num_rows > 0): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead><tr><th>User</th><th>Request</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php while ($req = $requests->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($req['user_name']); ?></td>
                                <td><?php echo htmlspecialchars(substr($req['request_text'], 0, 30)); ?>...</td>
                                <td>
                                    <?php if ($req['status'] == 'pending'): ?>
                                    <span style="color:var(--warning);">⏳</span>
                                    <?php elseif ($req['status'] == 'approved'): ?>
                                    <span style="color:var(--success);">✅</span>
                                    <?php else: ?>
                                    <span style="color:var(--danger);">❌</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <a href="manage_requests.php" class="btn btn-sm btn-secondary" style="margin-top:15px;">Lihat Semua →</a>
                <?php else: ?>
                <p style="color:var(--text-secondary);">Tidak ada request pending.</p>
                <?php endif; ?>
            </div>

            <div class="content-box animate-fade">
                <h2>🐛 Report Terbaru</h2>
                <?php if ($reports->num_rows > 0): ?>
                <div class="table-container">
                    <table class="data-table">
                        <thead><tr><th>User</th><th>Type</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php while ($rep = $reports->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rep['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($rep['bug_type']); ?></td>
                                <td>
                                    <?php if ($rep['status'] == 'open'): ?>
                                    <span style="color:var(--warning);">📂</span>
                                    <?php elseif ($rep['status'] == 'resolved'): ?>
                                    <span style="color:var(--success);">✅</span>
                                    <?php else: ?>
                                    <span style="color:var(--primary);">🔧</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <a href="manage_reports.php" class="btn btn-sm btn-secondary" style="margin-top:15px;">Lihat Semua →</a>
                <?php else: ?>
                <p style="color:var(--text-secondary);">Tidak ada report open.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="content-box animate-fade">
            <h2>📊 Activity Log Terbaru</h2>
            <?php if ($activities->num_rows > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead><tr><th>Waktu</th><th>User</th><th>Aksi</th><th>IP</th></tr></thead>
                    <tbody>
                        <?php while ($act = $activities->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('H:i d M', strtotime($act['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($act['user_name'] ?? 'Guest'); ?></td>
                            <td><?php echo htmlspecialchars(substr($act['action'], 0, 40)); ?>...</td>
                            <td><code style="font-size:11px;"><?php echo $act['ip_address']; ?></code></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <a href="activity_log.php" class="btn btn-sm btn-secondary" style="margin-top:15px;">Lihat Semua →</a>
            <?php else: ?>
            <p style="color:var(--text-secondary);">Belum ada aktivitas.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
