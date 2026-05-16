<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adm.php');
    exit;
}
require_once '../config.php';

if (isset($_POST['add'])) {
    $nama_file = $_POST['nama_file'];
    $size = $_POST['size'];
    $file_type = $_POST['file_type'];
    $fungsi = $_POST['fungsi'];
    $cmd_cara = $_POST['cmd_cara'];
    $share_by = $_SESSION['admin_username'];

    // Upload file monetloader
    $file_path = '';
    if (isset($_FILES['file_monetloader']) && $_FILES['file_monetloader']['error'] == 0) {
        $upload_dir = '../uploads/monetloader/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_name = time() . '_' . basename($_FILES['file_monetloader']['name']);
        $file_path = $upload_dir . $file_name;
        move_uploaded_file($_FILES['file_monetloader']['tmp_name'], $file_path);
    }

    // Upload preview
    $preview_path = '';
    if (isset($_FILES['preview']) && $_FILES['preview']['error'] == 0) {
        $upload_dir = '../uploads/preview/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $preview_name = time() . '_preview_' . basename($_FILES['preview']['name']);
        $preview_path = $upload_dir . $preview_name;
        move_uploaded_file($_FILES['preview']['tmp_name'], $preview_path);
    }

    $stmt = $conn->prepare("INSERT INTO monetloader (nama_file, file_path, size, file_type, fungsi, cmd_cara, preview_path, share_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama_file, $file_path, $size, $file_type, $fungsi, $cmd_cara, $preview_path, $share_by);

    if ($stmt->execute()) {
        $success = "MonetLoader berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add MonetLoader - Admin</title>
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
            <li><a href="add_monetloader.php" class="active">➕ Add MonetLoader</a></li>
            <li><a href="../home.php">🌐 Ke Website</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>➕ Tambah MonetLoader</h1>
        </div>

        <div class="content-box">
            <?php 
            if (isset($success)) echo "<p style='color:#00ff88;margin-bottom:20px;'>✅ $success</p>";
            if (isset($error)) echo "<p style='color:#ff6b6b;margin-bottom:20px;'>❌ $error</p>";
            ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>UPLOAD FILE LUA/LUAC</label>
                    <input type="file" name="file_monetloader" accept=".lua,.luac" required>
                </div>

                <div class="form-group">
                    <label>NAMA FILE</label>
                    <input type="text" name="nama_file" required>
                </div>

                <div class="form-group">
                    <label>SIZE</label>
                    <input type="text" name="size" placeholder="Contoh: 2.5 MB" required>
                </div>

                <div class="form-group">
                    <label>FILE PC/ANDRO</label>
                    <select name="file_type" required>
                        <option value="PC">PC</option>
                        <option value="Android">Android</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>FUNGSI</label>
                    <textarea name="fungsi" placeholder="Jelaskan fungsi monetloader..." required></textarea>
                </div>

                <div class="form-group">
                    <label>CMD/CARA PAKAI</label>
                    <textarea name="cmd_cara" placeholder="Masukkan CMD atau cara pakai..." required></textarea>
                </div>

                <div class="form-group">
                    <label>PREVIEW (PNG/MP4)</label>
                    <input type="file" name="preview" accept="image/*,video/*">
                </div>

                <div class="form-group">
                    <label>SHARE BY</label>
                    <input type="text" value="<?php echo $_SESSION['admin_username']; ?>" readonly>
                </div>

                <button type="submit" name="add" class="submit-btn">Tambah MonetLoader</button>
            </form>
        </div>
    </div>
</body>
</html>
