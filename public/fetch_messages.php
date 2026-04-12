<?php
include __DIR__.'/../config/db.php';

if(!isset($_SESSION['uid'])){
    exit;
}

$me = $_SESSION['uid'];
$to = $_GET['to'];

/* mark received messages as seen */
$conn->query("
UPDATE messages 
SET seen = 1 
WHERE sender_id=$to AND receiver_id=$me
");

/* fetch all messages */
$q = $conn->query("
SELECT * FROM messages 
WHERE (sender_id=$me AND receiver_id=$to)
   OR (sender_id=$to AND receiver_id=$me)
ORDER BY id ASC
");

while($m = $q->fetch_assoc()){

    $class = ($m['sender_id']==$me) ? 'me' : 'other';

    /* IMAGE MESSAGE */
    if(!empty($m['image'])){
        echo "<div class='msg $class'>
                <img src='/mini-insta-chat-advanced/public/uploads/{$m['image']}' width='120'>
              </div>";
    } 
    /* TEXT MESSAGE */
    else {
        if($m['sender_id']==$me){
            // show tick for my messages
            echo "<div class='msg me'>
                    {$m['message']} ".($m['seen'] ? '✔✔' : '✔')."
                  </div>";
        } else {
            echo "<div class='msg other'>{$m['message']}</div>";
        }
    }
}