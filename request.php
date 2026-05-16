<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
require_once 'config.php';

$success = $error = '';

if (isset($_POST['submit_request'])) {
    $user_name = $_SESSION['user_name'] ?? 'Anonymous';
    $request_text = $_POST['request_text'];

    $stmt = $conn->prepare("INSERT INTO requests (user_name, request_text) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_name, $request_text);

    if ($stmt->execute()) {
        $success = "Request berhasil dikirim! Admin akan review segera.";
        // Log activity
        $conn->query("INSERT INTO activity_log (user_name, action, ip_address) VALUES ('$user_name', 'Request file: $request_text', '{$_SERVER['REMOTE_ADDR']}')");
    } else {
        $error = "Gagal mengirim request!";
    }
}

// Get my requests
$my_requests = $conn->query("SELECT * FROM requests WHERE user_name = '" . ($_SESSION['user_name'] ?? 'Anonymous') . "' ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Request File - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="request.php" class="active"><span class="icon">📨</span> Request File</a></li>
            <li><a href="report.php"><span class="icon">🐛</span> Report Bug</a></li>
            <div class="menu-divider"></div>
            <li><a href="logout.php"><span class="icon">🚪</span> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>📨 Request File</h1>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>Request File</span>
        </div>

        <?php if ($success): ?>
        <div class="alert alert-success">✅ <?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
        <div class="alert alert-error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <div class="content-box animate-fade">
            <h2>📝 Kirim Request</h2>
            <p style="color:var(--text-secondary);margin-bottom:20px;">
                Request monetloader yang belum tersedia. Admin akan review dan upload jika memungkinkan.
            </p>
            <form method="POST">
                <div class="form-group">
                    <label>Nama File / Fitur yang Diinginkan</label>
                    <textarea name="request_text" placeholder="Contoh: AutoFish.lua untuk SAMP Android..." required></textarea>
                </div>
                <button type="submit" name="submit_request" class="btn btn-primary">📨 Kirim Request</button>
            </form>
        </div>

        <!-- My Requests -->
        <div class="content-box animate-fade">
            <h2>📋 Request Saya</h2>
            <?php if ($my_requests->num_rows > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr><th>Tanggal</th><th>Request</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($req = $my_requests->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($req['created_at'])); ?></td>
                            <td><?php echo htmlspecialchars(substr($req['request_text'], 0, 50)); ?>...</td>
                            <td>
                                <?php if ($req['status'] == 'pending'): ?>
                                <span style="color:var(--warning);">⏳ Pending</span>
                                <?php elseif ($req['status'] == 'approved'): ?>
                                <span style="color:var(--success);">✅ Approved</span>
                                <?php else: ?>
                                <span style="color:var(--danger);">❌ Rejected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state" style="padding:30px;">
                <div class="empty-icon">📭</div>
                <h3>Belum ada request</h3>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
