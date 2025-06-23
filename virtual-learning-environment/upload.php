<?php
require_once 'includes/auth_check.php';
include 'includes/header.php';
include 'config.php';

$user = $_SESSION['user'];

if ($user['role'] !== 'teacher') {
    echo "<p>Access denied. Only teachers can upload resources.</p>";
    include 'includes/footer.php';
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resource'])) {
    $title = $_POST['title'];
    $file = $_FILES['resource'];

    $upload_dir = 'uploads/';
    $filename = time() . "_" . basename($file['name']);
    $target_path = $upload_dir . $filename;

    $allowed = ['pdf', 'docx', 'pptx', 'mp4'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    if (in_array(strtolower($ext), $allowed) && move_uploaded_file($file['tmp_name'], $target_path)) {
        $stmt = $conn->prepare("INSERT INTO resources (user_id, title, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user['id'], $title, $target_path);
        if ($stmt->execute()) {
            $message = "Resource uploaded successfully.";
        } else {
            $message = "Database error. Try again.";
        }
    } else {
        $message = "Invalid file type or upload error.";
    }
}
?>

<h2>Upload Resource</h2>

<?php if ($message): ?>
    <p style="color:green;"><?php echo $message; ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Upload File:</label><br>
    <input type="file" name="resource" required><br><br>

    <button type="submit">Upload</button>
</form>

<?php include 'includes/footer.php'; ?>