<?php

session_start();

use App\Exceptions\InvalidSymbolsException;
use App\models\Auth;
use App\models\QueryBuilder;

$queryBuilder = new QueryBuilder();
$auth = new Auth($queryBuilder);

if(isset($_SESSION['user']) === false) {
    $auth->redirect('/log-in');
}

unset($_SESSION['user']);
$_SESSION['message'] = 'Вы успешно вышли';
$auth->redirect('/log-in');
exit;