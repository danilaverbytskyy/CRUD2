<?php

session_start();

use App\Exceptions\InvalidSymbolsException;
use App\Exceptions\NotFoundDataException;
use App\Exceptions\WrongPasswordException;
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
    $auth->redirect('/log-in');
    exit;
}

try {
    $auth->login("users", $_POST);
    $userInput = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];
    $userInput = $auth->secureInput($userInput);
    $userInformation = $queryBuilder->getOne('users', $userInput);
    $_SESSION['user'] = [
        'user_id' => $userInformation['user_id'],
        'name' => $userInformation['name'],
        'email' => $userInformation['email']
    ];
    $auth->redirect('/main');
} catch (InvalidSymbolsException $e) {
    $_SESSION['message'] = 'Вы ввели недопустимые символы';
    $auth->redirect('/log-in');
} catch (NotFoundDataException $e) {
    $_SESSION['message'] = 'Нет такого пользователя';
    $auth->redirect('/log-in');
} catch (WrongPasswordException $e) {
    $_SESSION['message'] = 'Вы ввели неправильный пароль';
    $auth->redirect('/log-in');
}