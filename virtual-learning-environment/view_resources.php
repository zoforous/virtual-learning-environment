<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'config.php';

echo "<h2>Available Resources</h2>";

$sql = "SELECT resources.title, resources.file_path, users.name AS uploader
        FROM resources
        JOIN users ON resources.user_id = users.id
        ORDER BY resources.uploaded_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($res = $result->fetch_assoc()) {
        echo "<li><strong>{$res['title']}</strong> uploaded by {$res['uploader']}<br>";
        echo "<a href='{$res['file_path']}' download>Download</a></li><br>";
    }
    echo "</ul>";
} else {
    echo "<p>No resources available yet.</p>";
}

include 'includes/footer.php';