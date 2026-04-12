<?php
include __DIR__.'/../config/db.php';

$me=$_SESSION['uid'];
$uid=$_GET['id'];

$conn->query("
DELETE FROM requests 
WHERE (sender_id=$me AND receiver_id=$uid)
OR (sender_id=$uid AND receiver_id=$me)
");

header("Location:/mini-insta-chat-advanced/public/home");
