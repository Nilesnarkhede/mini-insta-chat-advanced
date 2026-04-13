<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = getenv("MYSQL_URL");

if(!$url){
    die("MYSQL_URL not set");
}

$dbparts = parse_url($url);

$host = $dbparts['host'];
$user = $dbparts['user'];
$pass = $dbparts['pass'];
$db   = ltrim($dbparts['path'], '/');
$port = $dbparts['port'];

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}
?>
