<?php
function timeAgo($datetime){
    $time = strtotime($datetime);
    $diff = time() - $time;

    if($diff < 60) return "Just now";
    if($diff < 3600) return floor($diff/60)."m ago";
    if($diff < 86400) return floor($diff/3600)."h ago";
    return date("d M", $time);
}