<?php $this->layout('layout') ?>

<style>
    <?php include "css/sign-up.css" ?>
</style>

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