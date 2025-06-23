<?php
// config.php

// Database credentials
$host = 'localhost';
$db   = 'virtuallearningenvironment';
$user = 'root';
$pass = ''; // Update this if your MySQL has a password
$charset = 'utf8mb4';

// Create a new mysqli connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>