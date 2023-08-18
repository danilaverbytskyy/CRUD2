<?php
session_start();

if(isset($_SESSION['user'])) {
    header('Location: /main');
}
?>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: #ff6c00;
        margin: 0;
        background-image: url("img/back.png");
    }

    h2 {
        margin: 0;
        text-transform: uppercase;
        padding-bottom: 5px;
        border-bottom: 3px solid #5200a5;
    }

    form {
        margin: 0 auto;
        background: rgba(0, 186, 255, 0.77);
        width: 470px;
        height:470px;
        padding: 20px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.82);
    }

    .group {
        padding: 5px;
    }

    label {
        padding-left: 10px;
        text-transform: uppercase;
    }

    input {
        margin-top: 3px;
        height: 40px;
        width: 400px;
        border-radius: 20px/20px;
        border: none;
        padding-left: 15px;
        font-size: 18px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.82);
    }

    input:focus {
        border: 2px solid #6c00ff;
    }

    button {
        cursor: pointer;
        padding: 10px 30px;
        height: 50px;
        color: #fff;
        background: #5200a5;
        border: none;
        text-transform: uppercase;
        font-size: 15px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.82);
    }

    a, a:hover {
        text-decoration: none;
    }

    button:hover {
        font-weight: bold;
    }

    .msg {
        border: 2px solid #b67212;
        border-radius: 3px;
        padding: 10px;
        text-align: center;
        font-weight: bold;
    }
</style>

<!DOCKTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>
    <link rel="stylesheet" href="css/sign-up.css">
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