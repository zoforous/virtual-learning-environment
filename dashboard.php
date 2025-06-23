<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';

$user = $_SESSION['user'];
?>

<h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
<p>You are logged in as a <strong><?php echo $user['role']; ?></strong>.</p>

<?php if ($user['role'] === 'student'): ?>
    <ul>
        <li><a href="class_schedule.php">View Live Classes</a></li>
        <li><a href="view_resources.php">Download Resources</a></li>
    </ul>

<?php elseif ($user['role'] === 'teacher'): ?>
    <ul>
        <li><a href="upload.php">Upload Resources</a></li>
        <li><a href="class_schedule.php">Manage Your Classes</a></li>
    </ul>

<?php else: ?>
    <p>Admins should use the <a href="admin/dashboard.php">Admin Dashboard</a>.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>