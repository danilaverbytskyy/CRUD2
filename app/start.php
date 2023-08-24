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
else if($url === '/create-task') {
    require 'views/create-task.php';
}
else if($url === '/store') {
    require '../vendor/store.php';
}
else if(preg_match('/^\/show\/(\d+)$/', $url, $matches)) {
    $_GET['task_id'] = $matches[1];
    require 'views/show.php';
}
else {
    echo 'Error 404';
}
exit;