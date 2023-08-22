<?php

require_once __DIR__ . '/../helpers.php';

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addValidationError('email', 'Неверный email!');
    setMessage('error', 'Ошибка валидации');
}

if (empty($password)) {
    addValidationError('password', 'Пароль пустой!');
    setMessage('error', 'Ошибка валидации');
}

if (!empty($_SESSION['validation'])) {
    addOldValue('email', $email);
    redirect($_SERVER['HTTP_REFERER']);
}

$user = getUser($email);

if (!$user){
    setMessage('error', "Неверный логин или пароль");
    redirect($_SERVER['HTTP_REFERER']);
}

if (!password_verify($password, $user['password'])){
    setMessage('error', "Неверный логин или пароль");
    redirect($_SERVER['HTTP_REFERER']);
}

$_SESSION['user']['id'] = $user['id'];

redirect(APP_ROOT . '/home.php');