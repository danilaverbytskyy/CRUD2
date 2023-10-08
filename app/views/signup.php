<?php $this->layout('layout') ?>

<style>
    <?php include "css/sign-up.css" ?>
</style>

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
        <div>Уже есть аккаунт? <a href="/login">Войти</a></div>
    </center>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<center><p class="msg"> ' . $_SESSION['message'] . ' </p></center>';
    }
    unset($_SESSION['message']);
    ?>
</form>
</body>
