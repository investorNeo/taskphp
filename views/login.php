<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 15.07.20
 * Time: 3:03
 */
?>
<h3 class="text-center">Войти в систему</h3>
<form id="loginForm" action="/login" method="post">
    <div class="form-group">
        <label for="username_field">Имя пользователя *</label>
        <input class="form-control" type="text" name="username" id="username_field">
        <span id="username" class="task-info text-danger font-italic">
        <?php
        echo $response['username'] ?? '';
        ?>
        </span>
    </div>
    <div class="form-group">
        <label for="pass_field">Пароль *</label>
        <input class="form-control" type="password" name="pass" id="pass_field">
        <span id="pass" class="task-info text-danger font-italic">
        <?php
        echo $response['pass'] ?? '';
        ?>
        </span>
    </div>
    <button id="loginButton" class="btn btn-success">Сохранить</button>
    <span id="pass" class="task-info text-danger font-italic">
    <?php
    echo $response['status'] ?? '';
    ?>
</span>
</form>
