<?php
class MessageController{
 public static function send($conn){
  if(isset($_FILES['image'])){
    $img=$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],__DIR__.'/../../public/uploads/'.$img);
    $conn->query("INSERT INTO messages(sender_id,receiver_id,image) VALUES({$_SESSION['uid']},{$_POST['to']},'$img')");
  }else{
    $msg=$conn->real_escape_string($_POST['msg']);
    $conn->query("INSERT INTO messages(sender_id,receiver_id,message) VALUES({$_SESSION['uid']},{$_POST['to']},'$msg')");
  }
 }
 public static function fetch($conn){
  $me=$_SESSION['uid']; $to=$_GET['to'];
  $conn->query("UPDATE messages SET seen=1 WHERE receiver_id=$me AND sender_id=$to");
  $q=$conn->query("SELECT * FROM messages WHERE (sender_id=$me AND receiver_id=$to) OR (sender_id=$to AND receiver_id=$me)");
  while($m=$q->fetch_assoc()){
    echo $m['image'] ? "<img src='/uploads/{$m['image']}' width='100'><br>" : "<div>{$m['message']}</div>";
  }
 }
}
?>