<?php

use Delight\Auth\Auth;

session_start();

require 'autoload.php';

$db = new PDO('mysql:dbname=CRUD2;host=localhost;charset=utf8mb4', 'root', '');
$queryBuilder = new \App\models\QueryBuilder("CRUD2");
$auth = new Auth($db);

try {
    $auth->login($_POST['email'], $_POST['password']);
    $_SESSION['user'] = [
        'user_id' => $auth->getUserId(),
        'email' => $auth->getEmail(),
    ];
    $_SESSION['message'] = 'User is logged in';
    header("Location: /main");
    exit;
}
catch (\Delight\Auth\InvalidEmailException $e) {
    $_SESSION['message'] = 'Некорректный email';
}
catch (\Delight\Auth\InvalidPasswordException $e) {
    $_SESSION['message'] = 'Неверный пароль';
}
catch (\Delight\Auth\EmailNotVerifiedException $e) {
    $_SESSION['message'] = 'Email не подтвержден';
}
catch (\Delight\Auth\TooManyRequestsException $e) {
    $_SESSION['message'] = 'Слишком много запросов';
}
header("Location: /log-in");
exit;