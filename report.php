<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
require_once 'config.php';

$success = $error = '';

if (isset($_POST['submit_report'])) {
    $user_name = $_SESSION['user_name'] ?? 'Anonymous';
    $bug_type = $_POST['bug_type'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO reports (user_name, bug_type, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user_name, $bug_type, $description);

    if ($stmt->execute()) {
        $success = "Report bug berhasil dikirim! Tim akan segera fix.";
        $conn->query("INSERT INTO activity_log (user_name, action, ip_address) VALUES ('$user_name', 'Report bug: $bug_type', '{$_SERVER['REMOTE_ADDR']}')");
    } else {
        $error = "Gagal mengirim report!";
    }
}

// Get my reports
$my_reports = $conn->query("SELECT * FROM reports WHERE user_name = '" . ($_SESSION['user_name'] ?? 'Anonymous') . "' ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Report Bug - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="credits.php"><span class="icon">⭐</span> Credits</a></li>
            <div class="menu-divider"></div>
            <li><a href="request.php"><span class="icon">📨</span> Request File</a></li>
            <li><a href="report.php" class="active"><span class="icon">🐛</span> Report Bug</a></li>
            <div class="menu-divider"></div>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>🐛 Report Bug</h1>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>Report Bug</span>
        </div>

        <?php if ($success): ?>
        <div class="alert alert-success">✅ <?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
        <div class="alert alert-error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <div class="content-box animate-fade">
            <h2>📝 Laporkan Bug</h2>
            <p style="color:var(--text-secondary);margin-bottom:20px;">
                Temukan bug atau masalah? Laporkan di sini agar tim dapat segera memperbaiki.
            </p>
            <form method="POST">
                <div class="form-group">
                    <label>Jenis Bug</label>
                    <select name="bug_type" required>
                        <option value="">Pilih jenis bug...</option>
                        <option value="download_error">❌ Download Error</option>
                        <option value="file_corrupt">📁 File Corrupt/Rusak</option>
                        <option value="website_bug">🌐 Bug Website</option>
                        <option value="wrong_tutorial">📖 Tutorial Salah</option>
                        <option value="other">🔧 Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi Bug</label>
                    <textarea name="description" placeholder="Jelaskan bug yang ditemukan..." required></textarea>
                </div>
                <button type="submit" name="submit_report" class="btn btn-danger">🐛 Kirim Report</button>
            </form>
        </div>

        <!-- My Reports -->
        <div class="content-box animate-fade">
            <h2>📋 Report Saya</h2>
            <?php if ($my_reports->num_rows > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Tanggal</th><th>Type</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($rep = $my_reports->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($rep['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars($rep['bug_type']); ?></td>
                            <td>
                                <?php if ($rep['status'] == 'open'): ?>
                                <span style="color:var(--warning);">📂 Open</span>
                                <?php elseif ($rep['status'] == 'in_progress'): ?>
                                <span style="color:var(--primary);">🔧 In Progress</span>
                                <?php elseif ($rep['status'] == 'resolved'): ?>
                                <span style="color:var(--success);">✅ Resolved</span>
                                <?php else: ?>
                                <span style="color:var(--text-secondary);">🔒 Closed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state" style="padding:30px;">
                <div class="empty-icon">🐛</div>
                <h3>Belum ada report</h3>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
