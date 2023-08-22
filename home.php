<?php
require_once 'src/helpers.php';

$currentUser = getCurrentUser();
onlyUser();
?>

<!DOCTYPE html>
<html lang="ru" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>

<div class="card home">
    <?php if (file_exists($currentUser['avatar'])): ?>
        <img
                class="avatar"
                src="<?= $currentUser['avatar'] ?>"
                alt="{{ name }}"
        >
    <?php endif; ?>
    <h1>Привет, <?= $currentUser['name'] ?></h1>

    <form action="<?= APP_ROOT . '/src/action/logout.php' ?>" method="post">
        <button role="button">Выйти из аккаунта</button>
    </form>
</div>

<script src="assets/app.js"></script>
</body>
</html>