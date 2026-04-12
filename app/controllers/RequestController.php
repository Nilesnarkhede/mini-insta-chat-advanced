<?php
class RequestController{
 public static function send($conn,$to){
  $conn->query("INSERT INTO requests(sender_id,receiver_id) VALUES({$_SESSION['uid']},$to)");
 }
 public static function action($conn,$id,$act){
  $conn->query("UPDATE requests SET status='$act' WHERE id=$id");
 }
}
?>