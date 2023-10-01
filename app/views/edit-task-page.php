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
    if($task['user_id']!==$_SESSION['user']['user_id']) {
        echo 'Error 400';
        echo '<br>';
        echo "<a href='/main'>Go Back</a>";
        die;
    }
} catch (NotFoundDataException $e) {
    echo 'Error 403';
    echo '<br>';
    echo "<a href='/main'>Go Back</a>";
    die;
}
?>

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
            <h1>Edit Task</h1>
            <?php if(isset($task)):?>
                <form action="/edit-task/<?=$task['task_id']?>" method="post">
                    <div class="form-group">
                        <label>
                            <input type="text" name="title" class="form-control" value="<?= $task['title'];?>">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            <textarea name="content" class="form-control"><?= $task['content'];?></textarea>
                        </label>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-warning" type="submit">Submit</button>
                    </div>
                </form>
            <?php endif;?>
            <a href="/main">Go Back</a>
        </div>
    </div>
</div>
</body>
</html>
