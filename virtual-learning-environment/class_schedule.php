<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'config.php';

$user = $_SESSION['user'];
$role = $user['role'];

echo "<h2>Live Class Schedule</h2>";

if ($role === 'teacher') {
    echo "<a href='add_class.php'>+ Add New Class</a><br><br>";
    
    // Delete own class
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $conn->query("DELETE FROM classes WHERE id = $id AND teacher_id = {$user['id']}");
        header("Location: class_schedule.php");
        exit();
    }

    // Get only teacher's own classes
    $sql = "SELECT * FROM classes WHERE teacher_id = {$user['id']} ORDER BY schedule ASC";
} else {
    // Student/admin view: see all classes
    $sql = "SELECT classes.title, classes.schedule, classes.meet_link, users.name AS teacher
            FROM classes
            JOIN users ON classes.teacher_id = users.id
            ORDER BY classes.schedule ASC";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($class = $result->fetch_assoc()) {
        $title = htmlspecialchars($class['title']);
        $schedule = date("d M Y, h:i A", strtotime($class['schedule']));
        $meetLink = htmlspecialchars($class['meet_link']);
        $teacher = isset($class['teacher']) ? htmlspecialchars($class['teacher']) : $user['name']; // For teacher view

        echo "<li><strong>$title</strong> by $teacher<br>";
        echo "Scheduled on: $schedule<br>";
        echo "<a href='$meetLink' target='_blank'>Join Class</a>";

        // Show delete option only for the teacher's own classes
        if ($role === 'teacher') {
            echo " | <a href='?delete={$class['id']}' onclick=\"return confirm('Are you sure you want to delete this class?');\">Delete</a>";
        }

        echo "</li><br>";
    }
    echo "</ul>";
} else {
    echo "<p>No upcoming classes available.</p>";
}

include 'includes/footer.php';
?>