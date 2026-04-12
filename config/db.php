<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost","root","Nilesh@123456","mini_chat");

if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}
