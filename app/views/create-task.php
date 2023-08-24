<?php

use App\models\Auth;
use App\models\QueryBuilder;

session_start();

$queryBuilder = new QueryBuilder();
$auth = new Auth($queryBuilder);

if(isset($_SESSION['user']) === false) {
    $auth->redirect('/');
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
    <title>Add Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Create Task</h1>
            <form action="/store" method="post">
                <div class="form-group">
                    <label for="title"></label><input id="title" type="text" class="form-control" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content"></label><textarea id="content" name="content" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
