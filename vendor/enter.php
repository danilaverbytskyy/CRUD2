<?php

session_start();

use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

if(empty($_POST)) {
    echo 'Error 402';
    die;
}

$queryBuilder = new QueryBuilder();
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

