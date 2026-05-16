<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';

$id = intval($_GET['id'] ?? 0);

if (isset($_POST['update'])) {
    $nama_file = $_POST['nama_file'];
    $size = $_POST['size'];
    $file_type = $_POST['file_type'];
    $fungsi = $_POST['fungsi'];
    $cmd_cara = $_POST['cmd_cara'];

    $stmt = $conn->prepare("UPDATE monetloader SET nama_file=?, size=?, file_type=?, fungsi=?, cmd_cara=? WHERE id=?");
    $stmt->bind_param("sssssi", $nama_file, $size, $file_type, $fungsi, $cmd_cara, $id);

    if ($stmt->execute()) {
        $success = "Berhasil diupdate!";
    }
}

$result = $conn->query("SELECT * FROM monetloader WHERE id = $id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit MonetLoader - Admin</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>⚙️ Admin Panel</h2>
            <p><?php echo $_SESSION['admin_username']; ?></p>
        </div>
        <ul class="menu">
            <li><a href="dashboard.php">🏠 Home Admin</a></li>
            <li><a href="add_monetloader.php">➕ Add MonetLoader</a></li>
            <li><a href="../home.php">🌐 Ke Website</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>✏️ Edit MonetLoader</h1>
        </div>

        <div class="content-box">
            <?php if (isset($success)) echo "<p style='color:#00ff88;margin-bottom:20px;'>✅ $success</p>"; ?>

            <form method="POST">
                <div class="form-group">
                    <label>NAMA FILE</label>
                    <input type="text" name="nama_file" value="<?php echo htmlspecialchars($row['nama_file']); ?>" required>
                </div>

                <div class="form-group">
                    <label>SIZE</label>
                    <input type="text" name="size" value="<?php echo htmlspecialchars($row['size']); ?>" required>
                </div>

                <div class="form-group">
                    <label>FILE PC/ANDRO</label>
                    <select name="file_type" required>
                        <option value="PC" <?php echo $row['file_type']=='PC'?'selected':''; ?>>PC</option>
                        <option value="Android" <?php echo $row['file_type']=='Android'?'selected':''; ?>>Android</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>FUNGSI</label>
                    <textarea name="fungsi" required><?php echo htmlspecialchars($row['fungsi']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>CMD/CARA PAKAI</label>
                    <textarea name="cmd_cara" required><?php echo htmlspecialchars($row['cmd_cara']); ?></textarea>
                </div>

                <button type="submit" name="update" class="submit-btn">Update</button>
                <a href="dashboard.php" class="back-btn" style="margin-left:15px;">← Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>
