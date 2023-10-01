<?php

use App\Exceptions\NotFoundDataException;
use App\models\Auth;
use App\models\QueryBuilder;

session_start();

$queryBuilder = new QueryBuilder("CRUD2");
$auth = new Auth($queryBuilder);

if(isset($_SESSION['user']) === false) {
    $auth->redirect('/');
}

$taskId = intval($_GET['task_id']);

try {
    $task = $queryBuilder->getOneById("tasks", $taskId);
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
?>

<style>
    <?php include "css/main.css" ?>
</style>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($task)):?>
                <h1><?= $task['title'];?></h1>
                <p style="white-space: pre-line">
                    <?= $task['content'];?>
                </p>
            <?php endif;?>
            <a href="/main">Go Back</a>
        </div>
    </div>
</div>
</body>
</html>