<?php
include 'config.php';
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // storing as plain text
    $role = $_POST['role']; // 'student' or 'teacher'

    // Check if user already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}

?>

<?php include 'includes/header.php'; ?>

<h2>Register</h2>

<?php if ($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
<?php if ($success): ?><p style="color:green;"><?php echo $success; ?></p><?php endif; ?>

<form method="post" action="">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

<?php include 'includes/footer.php'; ?>