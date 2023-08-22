<?php

require_once __DIR__ . '/../helpers.php';


$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$confirmPassword = $_POST['password_confirmation'] ?? null;
$avatar = $_FILES['avatar'] ?? null;

$_SESSION['validation'] = [];

if (empty($name)) {
    addValidationError('name', 'Неверное имя!');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addValidationError('email', 'Неверный email!');
}

if (findSameEmail($email)){
    addValidationError('email', 'Данная почта уже зарегистрирована');
}

if (empty($password)) {
    addValidationError('password', 'Пароль пустой!');
}
if ($password != $confirmPassword) {
    addValidationError('password', 'Пароли не совпадают!');
}


if ($avatar['error'] != 4) {
    $types = ['image/jpeg', 'image/png'];

    if (!in_array($avatar['type'], $types)) {
        addValidationError('avatar', 'Изображение профиля имеет неверный тип');
    }
    if ($avatar['size'] / 1000000 >= 1) {
        addValidationError('avatar', 'Изображение должно быть меньше 1 Мб');
    }
}

if (!empty($_SESSION['validation'])) {
    addOldValue('name', $name);
    addOldValue('email', $email);
    redirect($_SERVER['HTTP_REFERER']);
}

$avatarPath = null;

if ($avatar['error'] != 4) {
    $avatarPath = uploadFile($avatar, 'avatar');
}

$pdo = getPDO();

$query = "INSERT INTO `users` (`name`, `email`, `avatar`, `password`) 
    VALUES (:name, :email, :avatar, :password)";

$params = [
    'name' => $name,
    'email' => $email,
    'avatar' => $avatarPath,
    'password' => password_hash($password, PASSWORD_DEFAULT),
];

$stmt = $pdo->prepare($query);
try {
    $stmt->execute($params);
} catch (PDOException $e){
    die($e->getMessage());
}


redirect(APP_ROOT);

