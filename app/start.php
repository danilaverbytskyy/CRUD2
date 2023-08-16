<?php

$url = $_SERVER['REQUEST_URI'];
$controller = [];
if($url === '/') {
    require 'views/sign-up.php';
}
else if($url === '/main') {
    require 'views/main.php';
}
else if($url === '/log-in') {
    require 'views/log-in.php';
}
else if($url === '/show') {
    require '/views/show.php';
}
else if($url === '/edit') {
    require 'views/edit.php';
}
else {
    echo 'Error 404';
}
exit;