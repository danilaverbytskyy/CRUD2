<?php

session_start();

if(empty($_POST)) {
    echo 'массив Post пустой';
    die;
}

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

$pdo = new PDO("mysql:host=localhost; dbname=CRUD", "root", "");
$queryBuilder = new QueryBuilder($pdo);
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