<?php

session_start();

if(empty($_POST)) {
    echo 'Error 400';
    die;
}

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

$queryBuilder = new QueryBuilder();
$auth = new Auth($queryBuilder);
try {
    $auth->register("users", $_POST);
    $_SESSION['message'] = 'Вы успешно зарегистрировались';
    $auth->redirect('/log-in');
} catch (AlreadyLoggedInException $e) {
    $_SESSION['message'] = 'Вы уже зарегистрированы';
    $auth->redirect('/');
} catch (InvalidSymbolsException $e) {
    $_SESSION['message'] = 'Вы ввели недопустимые символы';
    $auth->redirect('/');
}
?>