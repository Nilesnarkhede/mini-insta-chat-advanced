<?php include __DIR__.'/../../config/db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="/mini-insta-chat-advanced/public/assets/css/style.css">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Register</h2>

    <form method="POST" action="/mini-insta-chat-advanced/public/register_action.php" enctype="multipart/form-data">
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="pass" placeholder="Password" required>
      <input type="file" name="profile">
      <button type="submit">Create Account</button>
    </form>

    <p>Already have an account?
      <a href="/mini-insta-chat-advanced/public/login">Login</a>
    </p>
  </div>
</div>

</body>
</html>
