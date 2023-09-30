<?php

session_start();

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

$queryBuilder = new QueryBuilder();
$auth = new Auth($queryBuilder);

if(isset($_SESSION['user'])) {
    $auth->redirect('/main');
    exit;
}

if($auth->isCorrectEmail($_POST['email']) === false) {
    $_SESSION['message'] = 'Неккоректный email';
    $auth->redirect('/');
    exit;
}

try {
    $auth->register("users", $_POST);
    $_SESSION['message'] = 'Вы успешно зарегистрировались';
} catch (AlreadyLoggedInException $e) {
    $_SESSION['message'] = 'Вы уже зарегистрированы';
    $auth->redirect('/');
} catch (InvalidSymbolsException $e) {
    $_SESSION['message'] = 'Вы ввели недопустимые символы';
    $auth->redirect('/');
}
$auth->redirect('/log-in');
?>