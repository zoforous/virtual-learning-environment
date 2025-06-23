<?php include 'includes/header.php';
session_start();
?>

<section class="home">
    <h2>Welcome to the Virtual Learning Environment (VLE)</h2>
    <p>This platform allows students and teachers to connect, attend live classes, and share learning resources.</p>
    
    <?php if (!isset($_SESSION['user'])): ?>
        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to get started.</p>
    <?php else: ?>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>! <a href="dashboard.php">Go to Dashboard</a>.</p>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>