<?php
require_once __DIR__ . '/src/helpers.php';
onlyGuest();
?>

<!DOCTYPE html>
<html lang="ru" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>

<form class="card" method="post" enctype="multipart/form-data" action="src/action/register.php">
    <h2>Регистрация</h2>

    <label for="name">
        Имя
        <input
                type="text"
                id="name"
                name="name"
                placeholder="Иванов Иван"
                value="<?= getOldValue('name') ?>"
            <?= validationErrorAtr('name') ?>
        >
        <?php if (hasValidationError('name')): ?>
            <small><?= validationErrorMessage('name') ?></small>
        <?php endif; ?>
    </label>

    <label for="email">
        E-mail
        <input
                type="text"
                id="email"
                name="email"
                value="<?= getOldValue('email') ?>"
                placeholder="ivan@areaweb.su"
            <?= validationErrorAtr('email') ?>
        >
        <?php if (hasValidationError('email')): ?>
            <small><?= validationErrorMessage('email') ?></small>
        <?php endif; ?>
    </label>

    <label for="avatar">Изображение профиля
        <input
                type="file"
                id="avatar"
                name="avatar"
            <?= validationErrorAtr('avatar') ?>
        >
        <?php if (hasValidationError('avatar')): ?>
            <small><?= validationErrorMessage('avatar') ?></small>
        <?php endif; ?>
    </label>

    <div class="grid">
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

        <label for="password_confirmation">
            Подтверждение
            <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="******"

            >
        </label>
    </div>

    <fieldset>
        <label for="terms">
            <input
                    type="checkbox"
                    id="terms"
                    name="terms"
            >
            Я принимаю все условия пользования
        </label>
    </fieldset>

    <button
            type="submit"
            id="submit"
            disabled
    >Продолжить
    </button>
</form>

<p>У меня уже есть <a href="<?= APP_ROOT . '/index.php'?>">аккаунт</a></p>

<script src="assets/app.js"></script>
</body>
</html>