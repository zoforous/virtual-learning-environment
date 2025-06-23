<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Delete class if requested
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM classes WHERE id = $id");
    header("Location: manage_classes.php");
    exit();
}

// Get all classes with teacher name
$sql = "SELECT classes.id, classes.title, classes.schedule, classes.meet_link, users.name AS teacher
        FROM classes
        JOIN users ON classes.teacher_id = users.id
        ORDER BY classes.schedule DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes (Admin)</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h2>Manage All Scheduled Classes</h2>
    <a href="dashboard.php">← Back to Dashboard</a><br><br>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Schedule</th>
                <th>Teacher</th>
                <th>Meet Link</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= $row['schedule']; ?></td>
                    <td><?= htmlspecialchars($row['teacher']); ?></td>
                    <td><a href="<?= htmlspecialchars($row['meet_link']); ?>" target="_blank">Join</a></td>
                    <td>
                        <!-- Optional Edit link -->
                        <!-- <a href="edit_class.php?id=<?= $row['id']; ?>">Edit</a> | -->
                        <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No classes scheduled.</p>
    <?php endif; ?>

</body>
</html>
