<?php
require_once 'src/helpers.php';
onlyGuest();
?>

<!DOCTYPE html>
<html lang="ru" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>

<form class="card" method="post" action="src/action/login.php">
    <h2>Вход</h2>

    <?php if (hasMessage('error')): ?>
        <div class="notice error"><?= getMessage('error')?></div>
    <?php endif; ?>

    <label for="name">
        Логин
        <input
                type="text"
                id="email"
                name="email"
                placeholder="ivan@areaweb.su"
                value="<?= getOldValue('email') ?>"
            <?= validationErrorAtr('email') ?>
        >
        <?php if (hasValidationError('email')): ?>
            <small><?= validationErrorMessage('email') ?></small>
        <?php endif; ?>
    </label>

    <label for="password">
        Пароль
        <input
                type="password"
                id="password"
                name="password"
                placeholder="******"
            <?= validationErrorAtr('password') ?>
        >
        <?php if (hasValidationError('password')): ?>
            <small><?= validationErrorMessage('password') ?></small>
        <?php endif; ?>
    </label>

    <button
            type="submit"
            id="submit"
    >Продолжить
    </button>
</form>

<p>У меня еще нет <a href="<?= APP_ROOT . '/register.php' ?>">аккаунта</a></p>

<script src="assets/app.js"></script>
</body>
</html>