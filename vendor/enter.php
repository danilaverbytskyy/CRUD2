<?php

use App\Exceptions\AlreadyLoggedInException;
use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

$pdo = new PDO("mysql:host=localhost; dbname=CRUD", "root", "");
$queryBuilder = new QueryBuilder($pdo);
$auth = new Auth($queryBuilder);
try {
    $auth->login("users", $_POST);
    $_SESSION['message'] = 'Вы успешно вошли';
    $auth->redirect('/main');
    exit;
} catch (InvalidSymbolsException $e) {
    $_SESSION['message'] = 'Вы ввели недопустимые символы';
}
$auth->redirect('/log-in');
exit;
