<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virtual Learning Environment</title>
    <link rel="stylesheet" href="/virtual-learning-environment/css/style.css">
</head>
<body>
    <header>
        <h1>Virtual Learning Environment</h1>
        <nav>
            <ul>
                <li><a href="/virtual-learning-environment/index.php">Home</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="/virtual-learning-environment/dashboard.php">Dashboard</a></li>
                    <li><a href="/virtual-learning-environment/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/virtual-learning-environment/login.php">Login</a></li>
                    <li><a href="/virtual-learning-environment/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>