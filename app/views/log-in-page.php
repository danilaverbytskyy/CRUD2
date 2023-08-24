<?php
session_start();

if(isset($_SESSION['user'])) {
    header('Location: /main');
}
?>

<style>
    <?php include "css/sign-up.css" ?>
</style>

<!DOCKTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<br>
<form action="/enter" method="post" enctype="multipart/form-data">
    <center><h2 title="Форма регистрации">Вход</h2></center>
    <div class="group">
        <label for="email">Почта:</label>
        <input id="email" name="email" type="text" required>
    </div>
    <div class="group">
        <label for="password">Пароль:</label>
        <input id="password" name="password"  type="text" required>
    </div>
    <div class="group">
        <center>
            <button type="submit">Войти</button>
        </center>
    </div>
    <center>
        <div>Еще нет аккаунта? <a href="/">Зарегистрироваться</a> </div>
    </center>
    <?php
        if (isset($_SESSION['message'])) {
            echo '<center><p class="msg"> ' . $_SESSION['message'] . ' </p></center>';
        }
        unset($_SESSION['message']);
    ?>
</form>
</body>
</html>