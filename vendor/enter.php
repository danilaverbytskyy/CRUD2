<?php

session_start();

use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

if(empty($_POST)) {
    echo 'массив Post пустой';
    die;
}

$pdo = new PDO("mysql:host=localhost; dbname=CRUD", "root", "");
$queryBuilder = new QueryBuilder($pdo);
$auth = new Auth($queryBuilder);
try {
    $auth->login("users", $_POST);
    $_SESSION['message'] = 'Вы успешно вошли';
    $_SESSION['user'] = [
      'name' => $_POST['name'],
        'surname' => $_POST['surname']
    ];
    $auth->redirect('/main');
} catch (InvalidSymbolsException $exception) {
    $_SESSION['message'] = 'Вы ввели недопустимые символы';
    $auth->redirect('/log-in');
}

