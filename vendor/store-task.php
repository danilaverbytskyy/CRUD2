<?php

use App\models\Auth;
use App\models\QueryBuilder;

session_start();

$queryBuilder = new QueryBuilder("CRUD2");
$auth = new Auth($queryBuilder);

if (isset($_SESSION['user']) === false) {
    $auth->redirect('/');
    exit;
}

$storingInformation = [
    'user_id' => $_SESSION['user']['user_id'],
    'title' => $_POST['title'],
    'content' => $_POST['content']
];

$queryBuilder->storeOne('tasks', $storingInformation);
$auth->redirect('/main');