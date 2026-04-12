<?php
include __DIR__.'/../../config/db.php';
include __DIR__.'/../helpers/time.php';

if(!isset($_SESSION['uid'])){
    header("Location:/mini-insta-chat-advanced/public/login");
    exit;
}

$me = $_SESSION['uid'];
$search = $_GET['search'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
<title>Messages</title>
<link rel="stylesheet" href="/mini-insta-chat-advanced/public/assets/css/style.css">
</head>
<body>

<div class="navbar">
  <a href="/mini-insta-chat-advanced/public/home">🏠 Home</a>
  <a href="/mini-insta-chat-advanced/public/messages">💬 Messages</a>
  <a href="/mini-insta-chat-advanced/public/logout.php">🚪 Logout</a>
</div>

<div class="container">
<div class="card">

<h2>💬 Messages</h2>

<form method="GET">
  <input name="search" placeholder="Search messages..." value="<?php echo $search; ?>">
  <button>Search</button>
</form>

<?php
$q = $conn->query("
SELECT u.*,
(
  SELECT message FROM messages
  WHERE (sender_id=u.id AND receiver_id=$me)
     OR (sender_id=$me AND receiver_id=u.id)
  ORDER BY id DESC LIMIT 1
) AS last_msg,
(
  SELECT created_at FROM messages
  WHERE (sender_id=u.id AND receiver_id=$me)
     OR (sender_id=$me AND receiver_id=u.id)
  ORDER BY id DESC LIMIT 1
) AS last_time,
(
  SELECT COUNT(*) FROM messages
  WHERE sender_id=u.id AND receiver_id=$me AND seen=0
) AS unread
FROM users u
WHERE u.id!=$me AND u.name LIKE '%$search%'
HAVING last_msg IS NOT NULL
ORDER BY last_time DESC
");

if($q->num_rows==0){
    echo "<p>No messages yet</p>";
}

while($u=$q->fetch_assoc()){
?>

<div class="user">

<div class="user-left">
  <img src="/mini-insta-chat-advanced/public/uploads/<?php echo $u['profile']; ?>" width="45">

  <div>
    <b><?php echo $u['name']; ?></b><br>
    <small><?php echo $u['last_msg']; ?></small>
  </div>
</div>

<div>
  <small><?php echo timeAgo($u['last_time']); ?></small><br>

  <?php if($u['unread']>0){ ?>
    <span class="badge"><?php echo $u['unread']; ?></span>
  <?php } ?>
</div>

<a href="/mini-insta-chat-advanced/public/chat?to=<?php echo $u['id']; ?>">Open</a>

</div>

<?php } ?>

</div>
</div>

</body>
</html>