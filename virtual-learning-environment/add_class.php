<?php

include 'config.php';
include 'includes/auth_check.php';

$user = $_SESSION['user'];
if ($user['role'] !== 'teacher') {
    echo "Access denied.";
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $schedule = $_POST['schedule'];
    $meet_link = trim($_POST['meet_link']);

    $stmt = $conn->prepare("INSERT INTO classes (title, schedule, meet_link, teacher_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $schedule, $meet_link, $user['id']);
    if ($stmt->execute()) {
        $message = "Class added successfully!";
    } else {
        $message = "Error adding class.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<h2>Add New Class</h2>

<?php if ($message): ?><p style="color:green;"><?= $message ?></p><?php endif; ?>

<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Schedule (YYYY-MM-DD HH:MM):</label><br>
    <input type="datetime-local" name="schedule" required><br><br>

    <label>Meet Link:</label><br>
    <input type="url" name="meet_link" required><br><br>

    <button type="submit">Add Class</button>
</form>

<?php include 'includes/footer.php'; ?>