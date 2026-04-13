<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// environment variables
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$db   = getenv("DB_NAME");
$port = getenv("DB_PORT");

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}
?>
