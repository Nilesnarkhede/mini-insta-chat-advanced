<?php
include __DIR__.'/../config/db.php';

if(!isset($_SESSION['uid'])){
    exit;
}

$me = $_SESSION['uid'];
$to = $_POST['to'];

// TEXT MESSAGE
if(isset($_POST['msg']) && $_POST['msg'] != ''){
    $msg = $conn->real_escape_string($_POST['msg']);

    $conn->query("
        INSERT INTO messages(sender_id, receiver_id, message, seen)
        VALUES($me, $to, '$msg', 0)
    ");
}

// IMAGE MESSAGE
if(!empty($_FILES['image']['name'])){
    $img = time().'_'.$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/uploads/'.$img);

    $conn->query("
        INSERT INTO messages(sender_id, receiver_id, image, seen)
        VALUES($me, $to, '$img', 0)
    ");
}

exit;