<?php
include __DIR__.'/../config/db.php';

$me=$_SESSION['uid'];
$to=$_GET['to'];

$conn->query("INSERT INTO requests(sender_id,receiver_id) VALUES($me,$to)");

header("Location:/mini-insta-chat-advanced/public/home");
