<?php
include __DIR__ . '/../config/db.php';

$email = $_POST['email'];
$pass  = $_POST['pass'];

$q = $conn->query("SELECT * FROM users WHERE email='$email'");

if($q && $q->num_rows){
    $u = $q->fetch_assoc();

    if(password_verify($pass, $u['password'])){
        $_SESSION['uid'] = $u['id'];

        $conn->query("UPDATE users SET status='online' WHERE id={$u['id']}");

        header("Location:/mini-insta-chat-advanced/public/home");
        exit;
    }
}

echo "Invalid login details";
