<?php

use App\Exceptions\NotFoundByIdException;
use App\Exceptions\NotFoundDataException;
use App\models\Auth;
use App\models\QueryBuilder;

session_start();

$queryBuilder = new QueryBuilder();
$auth = new Auth($queryBuilder);

if(isset($_SESSION['user']) === false) {
    $auth->redirect('/');
}

$taskId=$_GET['task_id'];

try {
    $task = $queryBuilder->getOneById('tasks', $taskId);
} catch (NotFoundDataException $e) {
    echo 'Error 403';
    echo '<br>';
    echo "<a href='/main'>Go Back</a>";
    die;
}

if($task['user_id']!==$_SESSION['user']['user_id']) {
    echo 'Error 400';
    echo '<br>';
    echo "<a href='/main'>Go Back</a>";
    die;
}

$newTask = [
  'title' => $_POST['title'],
  'content' => $_POST['content']
];

try {
    $queryBuilder->updateOneById('tasks', $taskId, $newTask);
    $_SESSION['message'] = "Task was updated";
} catch (NotFoundByIdException $e) {
    $_SESSION['message'] = "Task was not updated";
}
$auth->redirect('/main');