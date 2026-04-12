<?php
include __DIR__ . '/../config/db.php';

$name  = $_POST['name'];
$email = $_POST['email'];
$pass  = password_hash($_POST['pass'], PASSWORD_DEFAULT);

// profile image
$img = "";
if (!empty($_FILES['profile']['name'])) {
    $img = $_FILES['profile']['name'];
    move_uploaded_file($_FILES['profile']['tmp_name'], __DIR__ . '/uploads/' . $img);
}

$conn->query("INSERT INTO users(name,email,password,profile) 
              VALUES('$name','$email','$pass','$img')");

header("Location:/mini-insta-chat-advanced/public/login");
exit;
