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

try {
    $tasks = $queryBuilder->getAllByUserId("tasks", $_SESSION['user']['user_id']);
    $_SESSION['message'] = "Welcome, " . $_SESSION['user']['name'] . '!';
} catch (NotFoundDataException $e) {
    $_SESSION['message'] = 'You have no tasks yet :(';
}
?>

<style>
    <?php include "css/main.css" ?>
</style>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <a href="/logout">Log out</a>
        <div class="col-md-12">
            <h1>All Tasks</h1>
            <a href="/create-task" class="btn btn-success">Add Task</a>
            <?php echo '<br>' . $_SESSION['message']?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($tasks)):?>
                    <?php $taskCounter = 0;?>
                    <?php foreach($tasks as $task):?>
                        <tr>
                            <td><?= ++$taskCounter;?></td>
                            <td><?= $task['title'];?></td>
                            <td>
                                <a href="/show/<?= $task['task_id'];?>" class="btn btn-info">
                                    Show
                                </a>
                                <a href=/"edit/id=<?= $task['task_id'];?>" class="btn btn-warning">
                                    Edit
                                </a>
                                <a onclick="return confirm('are you sure?');" href="/delete/id=<?= $task['task_id'];?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
