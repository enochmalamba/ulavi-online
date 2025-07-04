<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'ulavi_community';

// Database connection
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session configuration will be handled in init.php