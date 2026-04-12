<?php include __DIR__.'/../../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- CSS LINK (add here) -->
    <link rel="stylesheet" href="/mini-insta-chat-advanced/public/assets/css/style.css">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Login</h2>

    <form method="POST" action="/mini-insta-chat-advanced/public/login_action.php">
      <input name="email" placeholder="Email" required>
      <input type="password" name="pass" placeholder="Password" required>
      <button>Login</button>
    </form>

    <p>Don't have an account?
      <a href="/mini-insta-chat-advanced/public/register">Register</a>
    </p>
  </div>
</div>

</body>
</html>
