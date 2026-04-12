<?php
include __DIR__.'/../config/db.php';

// Check login
if(!isset($_SESSION['uid'])){
    header("Location:/mini-insta-chat-advanced/public/login");
    exit;
}

// Validate params
if(!isset($_GET['id']) || !isset($_GET['act'])){
    die("Invalid request");
}

$id  = (int)$_GET['id'];
$act = $_GET['act'];

// Only allow valid actions
if($act === 'accepted' || $act === 'rejected'){
    $stmt = $conn->prepare("UPDATE requests SET status=? WHERE id=?");
    $stmt->bind_param("si", $act, $id);
    $stmt->execute();
}

header("Location:/mini-insta-chat-advanced/public/home");
exit;
