<?php

use Delight\Auth\Auth;
use Delight\Auth\NotLoggedInException;

if(session_status() == false) {
    session_start();
}

require 'autoload.php';

$db = new PDO('mysql:dbname=CRUD2;host=localhost;charset=utf8mb4', 'root', '');

$auth = new Auth($db);
try {
    $auth->logOutEverywhere();
}
catch (NotLoggedInException $e) {
    die('Not logged in');
}
unset($_SESSION['user']);
$_SESSION['message'] = 'Вы успешно вышли';
header('Location: /log-in');
exit;