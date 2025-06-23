<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $user_id AND role != 'admin'");
    header("Location: manage_users.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, role FROM users WHERE role != 'admin'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Manage Users</h2>
    <a href="dashboard.php">← Back to Dashboard</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Delete user?');">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>