<?php
include __DIR__.'/../config/db.php';

$me = $_SESSION['uid'];
$to = $_POST['to'];

$conn->query("UPDATE users SET typing_to=$to WHERE id=$me");