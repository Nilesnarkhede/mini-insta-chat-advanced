<?php
include __DIR__.'/../../config/db.php';

if(!isset($_SESSION['uid'])){
    header("Location:/mini-insta-chat-advanced/public/login");
    exit;
}

$me = $_SESSION['uid'];
$to = $_GET['to'] ?? 0;

if(!$to){
    echo "User not selected";
    exit;
}

// Get receiver info
$receiver = $conn->query("SELECT * FROM users WHERE id=$to")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
<title>Chat</title>
<link rel="stylesheet" href="/mini-insta-chat-advanced/public/assets/css/style.css">
</head>

<body>

<div class="chat-wrapper">

  <div class="chat-header">
     <?php echo $receiver['name']; ?>
  </div>

  <div id="chatBox" class="chat-box"></div>

  <div id="typing" style="padding-left:10px;color:gray;font-size:13px;"></div>

  <div class="chat-input-area">
    <input id="msg" placeholder="Type message...">
    <button onclick="send()">Send</button>
  </div>

  <div class="upload-area">
    <input type="file" id="img">
    <button onclick="sendImg()">Send Image</button>
  </div>

</div>

<script>
let to = <?php echo $to; ?>;
let lastData = "";

// Load messages without flicker
function loadChat(){
  fetch('/mini-insta-chat-advanced/public/fetch_messages.php?to='+to)
  .then(r=>r.text())
  .then(d=>{
    if(d !== lastData){
      let box = document.getElementById('chatBox');
      box.innerHTML = d;
      box.scrollTop = box.scrollHeight;
      lastData = d;
    }
  });
}
setInterval(loadChat,1000);

// Send text message
function send(){
  let m = document.getElementById('msg').value.trim();
  if(m=="") return;

  fetch('/mini-insta-chat-advanced/public/send_message.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'to='+to+'&msg='+encodeURIComponent(m)
  });

  document.getElementById('msg').value='';
}

// Send image
function sendImg(){
  let f = new FormData();
  f.append('to',to);
  f.append('image',document.getElementById('img').files[0]);

  fetch('/mini-insta-chat-advanced/public/send_message.php',{
    method:'POST',
    body:f
  });
}

// Typing indicator
let typingTimer;
document.getElementById("msg").addEventListener("input", function(){

  fetch('/mini-insta-chat-advanced/public/typing.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'to='+to
  });

  clearTimeout(typingTimer);

  typingTimer = setTimeout(()=>{
    fetch('/mini-insta-chat-advanced/public/typing.php',{
      method:'POST',
      headers:{'Content-Type':'application/x-www-form-urlencoded'},
      body:'to=0'
    });
  },1000);
});

// Check typing
function checkTyping(){
  fetch('/mini-insta-chat-advanced/public/check_typing.php?to='+to)
  .then(r=>r.text())
  .then(d=>document.getElementById("typing").innerHTML=d);
}
setInterval(checkTyping,1000);

</script>

</body>
</html>