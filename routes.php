<?php

// Simple Router
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// remove project folder from URL
$base = '/mini-insta-chat-advanced/public';
$route = str_replace($base, '', $path);

if ($route == '/' || $route == '/login') {
    include __DIR__.'/app/views/login.php';
}
elseif ($route == '/register') {
    include __DIR__.'/app/views/register.php';
}
elseif ($route == '/home') {
    include __DIR__.'/app/views/home.php';
}
elseif ($route == '/chat') {
    include __DIR__.'/app/views/chat.php';
}elseif ($route == '/messages') {
    include __DIR__.'/app/views/messages.php';
}
else {
    echo "Page not found";
}
