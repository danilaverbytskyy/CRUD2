<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: /main');
}
?>

<style>
    <?php include "../../bootstrap/css/bootstrap.min.css" ?>
    <?php include "css/sign-up.css" ?>
</style>

<!DOCKTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/sign-up.css">
</head>
<body>
<br>
<form action="/register" method="post" enctype="multipart/form-data">
    <center><h2 title="Форма регистрации">Регистрация</h2></center>
    <div class="group">
        <label for="name">Имя:</label>
        <input id="name" name="name" type="text" required>
    </div>
    <div class="group">
        <label for="email">Почта:</label>
        <input id="email" name="email" type="text" required>
    </div>
    <div class="group">
        <label for="password">Пароль:</label>
        <input id="password" name="password" type="text" required>
    </div>
    <div class="group">
        <center>
            <button type="submit">Зарегистрироваться</button>
        </center>
    </div>
    <center>
        <div>Уже есть аккаунт? <a href="/log-in">Войти</a></div>
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