<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Delete resource
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Get file path to remove it from disk
    $res = $conn->query("SELECT file_path FROM resources WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        if (file_exists("../" . $row['file_path'])) {
            unlink("../" . $row['file_path']);
        }
    }
    $conn->query("DELETE FROM resources WHERE id = $id");
    header("Location: manage_resources.php");
    exit();
}

// List all resources
$sql = "SELECT resources.id, resources.title, resources.file_path, users.name AS uploader
        FROM resources
        JOIN users ON resources.user_id = users.id
        ORDER BY resources.uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Resources</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Manage Uploaded Resources</h2>
    <a href="dashboard.php">← Back to Dashboard</a><br><br>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Uploader</th>
                <th>File</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['uploader']); ?></td>
                    <td><a href="../<?= $row['file_path']; ?>" target="_blank">View</a></td>
                    <td>
                        <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this resource?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No resources uploaded.</p>
    <?php endif; ?>

</body>
</html>