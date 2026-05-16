<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit;
}
require_once 'config.php';

// Get stats
$stats = $conn->query("SELECT 
    COUNT(*) as total_files,
    SUM(CASE WHEN file_type = 'PC' THEN 1 ELSE 0 END) as pc_count,
    SUM(CASE WHEN file_type = 'Android' THEN 1 ELSE 0 END) as android_count,
    COUNT(DISTINCT share_by) as total_sharers
FROM monetloader")->fetch_assoc();

$latest = $conn->query("SELECT * FROM monetloader ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Home - Share MonetLoader SAMP by Rexxy</title>
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
            <li><a href="home.php" class="active"><span class="icon">🏠</span> Home</a></li>
            <li><a href="file.php"><span class="icon">📁</span> File</a></li>
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
            <h1>🏠 Dashboard</h1>
            <div class="header-actions">
                <a href="file.php" class="btn btn-primary btn-sm">📁 Lihat File</a>
            </div>
        </div>

        <div class="breadcrumb">
            <a href="home.php">Home</a>
            <span>/</span>
            <span>Dashboard</span>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card animate-fade">
                <div class="stat-icon">📦</div>
                <h3>Total File</h3>
                <div class="value"><?php echo $stats['total_files'] ?? 0; ?></div>
                <div class="trend">📈 File tersedia</div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.1s">
                <div class="stat-icon">💻</div>
                <h3>File PC</h3>
                <div class="value"><?php echo $stats['pc_count'] ?? 0; ?></div>
                <div class="trend">🎮 Untuk PC</div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.2s">
                <div class="stat-icon">📱</div>
                <h3>File Android</h3>
                <div class="value"><?php echo $stats['android_count'] ?? 0; ?></div>
                <div class="trend">🤖 Untuk Mobile</div>
            </div>
            <div class="stat-card animate-fade" style="animation-delay:0.3s">
                <div class="stat-icon">👥</div>
                <h3>Sharers</h3>
                <div class="value"><?php echo $stats['total_sharers'] ?? 0; ?></div>
                <div class="trend">🤝 Kontributor</div>
            </div>
        </div>

        <!-- Welcome Box -->
        <div class="content-box animate-fade">
            <h2>👋 Selamat Datang di Share MonetLoader SAMP</h2>
            <p>Website ini adalah platform untuk berbagi dan mengunduh MonetLoader untuk GTA SAMP. MonetLoader adalah tools/scripts yang digunakan untuk memudahkan gameplay di GTA San Andreas Multiplayer.</p>

            <h3>🎯 Fitur Utama:</h3>
            <ul style="margin-left:20px; color:var(--text-secondary);">
                <li>📁 Download berbagai MonetLoader (PC & Android)</li>
                <li>👁️ Preview file sebelum download (Video & Gambar)</li>
                <li>📖 Tutorial penggunaan lengkap dengan CMD</li>
                <li>⭐ Credits untuk tim pengembang</li>
                <li>📨 Request file yang belum tersedia</li>
            </ul>

            <h3>⚠️ Peraturan Penggunaan:</h3>
            <ul style="margin-left:20px; color:var(--text-secondary);">
                <li>Gunakan MonetLoader dengan bijak</li>
                <li>Jangan share password website ke orang lain</li>
                <li>Report bug jika menemukan masalah</li>
                <li>Kami tidak bertanggung jawab atas banned akun</li>
            </ul>
        </div>

        <!-- Latest Files -->
        <div class="content-box animate-fade">
            <h2>🆕 File Terbaru</h2>
            <?php if ($latest->num_rows > 0): ?>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama File</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Share By</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $latest->fetch_assoc()): ?>
                        <tr>
                            <td>📄 <?php echo htmlspecialchars($row['nama_file']); ?></td>
                            <td><span class="badge badge-<?php echo strtolower($row['file_type']); ?>"><?php echo $row['file_type']; ?></span></td>
                            <td><?php echo $row['size']; ?></td>
                            <td><?php echo htmlspecialchars($row['share_by']); ?></td>
                            <td><a href="<?php echo $row['file_path']; ?>" class="btn btn-sm btn-primary" download>⬇️</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Belum ada file</h3>
                <p>Admin akan segera menambahkan file monetloader.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
