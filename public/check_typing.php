<?php
include __DIR__.'/../config/db.php';

$me = $_SESSION['uid'];
$to = $_GET['to'];

$q = $conn->query("SELECT typing_to FROM users WHERE id=$to");
$u = $q->fetch_assoc();

if($u['typing_to'] == $me){
 echo "Typing...";
}