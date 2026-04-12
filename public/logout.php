<?php
include __DIR__ . '/../config/db.php';

if (isset($_SESSION['uid'])) {
    // Set user offline
    $uid = $_SESSION['uid'];
    $conn->query("UPDATE users SET status='offline' WHERE id=$uid");

    // Destroy session
    session_unset();
    session_destroy();
}

// Redirect to login
header("Location:/mini-insta-chat-advanced/public/login");
exit;
