<?php

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
    var_dump($_SESSION['message']);
    header("Location: /log-in");
    exit;
} catch (AlreadyLoggedInException $e) {
    $_SESSION['message'] = 'Вы уже зарегистрированы';
} catch (InvalidSymbolsException $e) {
    $_SESSION['message'] = 'Вы ввели недопустимые символы';
}
header("Location: /");
exit;
?>