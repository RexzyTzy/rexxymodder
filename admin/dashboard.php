<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MonetLoader</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>⚙️ Admin Panel</h2>
            <p><?php echo $_SESSION['admin_username']; ?></p>
        </div>
        <ul class="menu">
            <li><a href="dashboard.php" class="active">🏠 Home Admin</a></li>
            <li><a href="add_monetloader.php">➕ Add MonetLoader</a></li>
            <li><a href="../home.php">🌐 Ke Website</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="admin-header">
            <h1>🏠 Dashboard Admin</h1>
            <a href="add_monetloader.php" class="download-btn">+ Tambah MonetLoader</a>
        </div>

        <div class="content-box">
            <h2>📊 Selamat Datang, <?php echo $_SESSION['admin_username']; ?>!</h2>
            <p>Ini adalah panel admin untuk mengelola MonetLoader.</p>

            <h3 style="margin-top:20px; color:#ffd700;">📁 Daftar MonetLoader:</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama File</th>
                        <th>Size</th>
                        <th>Type</th>
                        <th>Share By</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM monetloader ORDER BY created_at DESC");
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_file']); ?></td>
                        <td><?php echo htmlspecialchars($row['size']); ?></td>
                        <td><?php echo htmlspecialchars($row['file_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['share_by']); ?></td>
                        <td class="action-btns">
                            <a href="edit_monetloader.php?id=<?php echo $row['id']; ?>" class="edit-btn">✏️ Edit</a>
                            <a href="remove_monetloader.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Yakin hapus?')">🗑️ Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
