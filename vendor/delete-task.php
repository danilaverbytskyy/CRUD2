<?php

use App\Exceptions\NotFoundDataException;
use App\models\Auth;
use App\models\QueryBuilder;

session_start();

$queryBuilder = new QueryBuilder("CRUD2");
$auth = new Auth($queryBuilder);

if (isset($_SESSION['user']) === false) {
    $auth->redirect('/');
}

$taskId = intval($_GET['task_id']);
try {
    $task = $queryBuilder->getOneById("tasks", $taskId);
    if ($task['user_id'] === $_SESSION['user']['user_id']) {
        $queryBuilder->deleteById('tasks', $taskId);
    }
} catch (NotFoundDataException $e) {
    $auth->redirect('/main');
}
$auth->redirect('/main');
exit;