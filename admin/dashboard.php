<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Welcome, Admin <?php echo htmlspecialchars($_SESSION['user']['name']); ?></h2>

    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_classes.php">Manage Classes</a></li>
        <li><a href="manage_resources.php">Manage Resources</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>