<?php
session_start();
include 'config.php'; // IMPORTANT: This must come before using $conn

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) {
        $_SESSION['user'] = $user;

        // Redirect by role
        if ($user['role'] === 'admin') {
            header("Location: /admin/dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="post" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
