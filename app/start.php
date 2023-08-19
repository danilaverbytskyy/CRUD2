<?php

$url = $_SERVER['REQUEST_URI'];
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
else if($url === '/register') {
    require '../vendor/register.php';
}
else if($url === '/enter') {
    require '../vendor/enter.php';
}
else if($url === '/logout') {
    require '../vendor/logout.php';
}
else {
    echo 'Error 404';
}
exit;