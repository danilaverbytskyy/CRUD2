<?php

$url = $_SERVER['REQUEST_URI'];
if($url === '/') {
    require 'views/sign-up-page.php';
}
else if($url === '/main') {
    require 'views/main-page.php';
}
else if($url === '/log-in') {
    require 'views/log-in-page.php';
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
    require 'views/create-task-page.php';
}
else if($url === '/store') {
    require '../vendor/store-task.php';
}
else if($url === '/edit') {
    require '../vendor/edit-task.php';
}
else if(preg_match('/^\/show\/(\d+)$/', $url, $matches)) {
    $_GET['task_id'] = $matches[1];
    require 'views/show-page.php';
}
else if(preg_match('/^\/edit\/(\d+)$/', $url, $matches)) {
    $_GET['task_id'] = $matches[1];
    require 'views/edit-task-page.php';
}
else if(preg_match('/^\/delete\/(\d+)$/', $url, $matches)) {
    $_GET['task_id'] = $matches[1];
    require '../vendor/delete-task.php';
}
else {
    echo 'Error 404';
}
exit;