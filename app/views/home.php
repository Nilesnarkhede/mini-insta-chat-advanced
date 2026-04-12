<?php
include __DIR__.'/../../config/db.php';

if(!isset($_SESSION['uid'])){
    header("Location:/mini-insta-chat-advanced/public/login");
    exit;
}

$me = $_SESSION['uid'];
$my = $conn->query("SELECT * FROM users WHERE id=$me")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link rel="stylesheet" href="/mini-insta-chat-advanced/public/assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <a href="/mini-insta-chat-advanced/public/home">🏠 Home</a>
  <a href="/mini-insta-chat-advanced/public/logout.php" class="logout">🚪 Logout</a>
<?php
$n = $conn->query("SELECT COUNT(*) c FROM messages WHERE receiver_id=$me AND seen=0")->fetch_assoc();
?>

<a href="/mini-insta-chat-advanced/public/messages">
💬 Messages (<?php echo $n['c']; ?>)
</a>
</div>

<div class="container">

<!-- PROFILE -->
<div class="card">
  <img src="/mini-insta-chat-advanced/public/uploads/<?php echo $my['profile']; ?>" width="60">
  <h3><?php echo $my['name']; ?></h3>
  <p><?php echo $my['status']; ?></p>
</div>

<!-- USERS LIST -->
<div class="card">
<h3>Users</h3>

<?php
$q = $conn->query("SELECT * FROM users WHERE id != $me");

while($u = $q->fetch_assoc()){
    $uid = $u['id'];

    // check request or friend
    $check = $conn->query("
        SELECT * FROM requests
        WHERE (sender_id=$me AND receiver_id=$uid)
        OR (sender_id=$uid AND receiver_id=$me)
    ");

    $req = $check->fetch_assoc();
?>

<div class="user">
  <img src="/mini-insta-chat-advanced/public/uploads/<?php echo $u['profile']; ?>" width="40">
  <b><?php echo $u['name']; ?></b>

  <div>
    <a href="/mini-insta-chat-advanced/public/chat?to=<?php echo $uid; ?>">Message</a>

    <?php if(!$req){ ?>
      <a href="/mini-insta-chat-advanced/public/send_request.php?to=<?php echo $uid; ?>">Request</a>
    <?php } elseif($req['status']=='pending'){ ?>
      <span>Pending</span>
    <?php } elseif($req['status']=='accepted'){ ?>
      <span>Friend</span>
    <?php } ?>
  </div>
</div>

<?php } ?>
</div>

<!-- FRIEND REQUESTS -->
<div class="card">
<h3>Friend Requests</h3>

<?php
$r = $conn->query("SELECT * FROM requests WHERE receiver_id=$me AND status='pending'");

if($r->num_rows==0){
    echo "No requests";
}

while($req=$r->fetch_assoc()){
    $sender = $conn->query("SELECT * FROM users WHERE id={$req['sender_id']}")->fetch_assoc();
?>

<div class="user">
  <img src="/mini-insta-chat-advanced/public/uploads/<?php echo $sender['profile']; ?>" width="40">
  <?php echo $sender['name']; ?>

  <a href="/mini-insta-chat-advanced/public/request_action.php?id=<?php echo $req['id']; ?>&act=accepted">Accept</a>
  <a href="/mini-insta-chat-advanced/public/request_action.php?id=<?php echo $req['id']; ?>&act=rejected">Reject</a>
</div>

<?php } ?>
</div>

<!-- FRIEND LIST -->
<div class="card">
<h3>Your Friends</h3>

<?php
$f = $conn->query("
SELECT u.* FROM users u
JOIN requests r ON
(
 (r.sender_id=u.id AND r.receiver_id=$me)
 OR
 (r.receiver_id=u.id AND r.sender_id=$me)
)
WHERE r.status='accepted' AND u.id!=$me
");

if($f->num_rows==0){
    echo "No friends yet";
}

while($fr=$f->fetch_assoc()){
?>

<div class="user">
  <img src="/mini-insta-chat-advanced/public/uploads/<?php echo $fr['profile']; ?>" width="40">
  <?php echo $fr['name']; ?>

  <a href="/mini-insta-chat-advanced/public/chat?to=<?php echo $fr['id']; ?>">Message</a>
  <a href="/mini-insta-chat-advanced/public/unfriend.php?id=<?php echo $fr['id']; ?>">Unfriend</a>
</div>

<?php } ?>
</div>

</div>
</body>
</html>
