<?php

use Delight\Auth\Auth;

if(session_status() == false) {
    session_start();
}

require 'autoload.php';

$db = new PDO('mysql:dbname=CRUD2;host=localhost;charset=utf8mb4', 'root', '');
$auth = new Auth($db);

try {
    $userId = $auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) use ($auth) {
        $auth->confirmEmail(urldecode($selector), urldecode($token));
    });
    $_SESSION['message'] = "Вы успешно зарегистрировались";
    header("Location: /log-in");
} catch (\Delight\Auth\InvalidEmailException $e) {
    $_SESSION['message'] = 'Некорректный email';
    header("Location: /");
} catch (\Delight\Auth\InvalidPasswordException $e) {
    $_SESSION['message'] = "Некорректный пароль";
    header("Location: /");
} catch (\Delight\Auth\UserAlreadyExistsException $e) {
    $_SESSION['message'] = "Вы уже зарегистрированы";
    header("Location: /");
} catch (\Delight\Auth\TooManyRequestsException $e) {
    $_SESSION['message'] = "Слишком много запросов";
    header("Location: /");
}
exit;
?>