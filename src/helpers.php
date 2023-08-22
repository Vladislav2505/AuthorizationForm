<?php

session_start();
require_once 'config.php';

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function redirect(string $path): void
{
    header("Location: $path");
    die();
}

function addValidationError(string $fieldName, string $message): void
{
    $_SESSION['validation'][$fieldName] = $message;
}

function hasValidationError(string $fieldName): bool
{
    return isset($_SESSION['validation'][$fieldName]);
}

function validationErrorAtr(string $fieldName): string
{
    return isset($_SESSION['validation'][$fieldName]) ? 'aria-invalid="true"' : '';
}

function validationErrorMessage(string $fieldName): string
{
    $value = $_SESSION['validation'][$fieldName];
    unset($_SESSION['validation'][$fieldName]);
    return $value ?? '';
}

function addOldValue($key, $value): void
{
    $_SESSION['old'][$key] = $value;
}

function getOldValue($key)
{
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function uploadFile($file, $prefix): string
{
    $uploadPath = __DIR__ . '\..\uploads';

    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = $prefix . '_' . time() . ".$ext";

    if (!move_uploaded_file($file['tmp_name'], "$uploadPath/$fileName")) {
        die();
    }
    return 'uploads/' . $fileName;
}

function getPDO(): PDO
{
    try {
        return new PDO('mysql:host=' . HOST . ';dbname=' . DB_NANE, USERNAME, PASSWORD);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function findSameEmail(string $email): bool
{
    $pdo = getPDO();
    $query = "SELECT email from `users` WHERE `email`=:email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    return $stmt->rowCount();
}

function setMessage(string $key, string $message): void
{
    $_SESSION['message'][$key] = $message;
}

function getMessage(string $key): string
{
    $value = $_SESSION['message'][$key];
    unset($_SESSION['message'][$key]);
    return $value ?? '';
}

function hasMessage($key): bool
{
    return isset($_SESSION['message'][$key]);
}

function getUser($email): array
{
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email`=:email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCurrentUser(): array|false
{
    if (!isset($_SESSION['user'])) {
        return false;
    }

    $pdo = getPDO();

    $userId = $_SESSION['user']['id'];

    $query = "SELECT * from `users` WHERE `id`=:id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

#[NoReturn] function logout(): void
{
    unset($_SESSION['user']);
    redirect(APP_ROOT . '/index.php');
}

function onlyUser(): void
{
    if (!isset($_SESSION['user']['id'])){
        redirect(APP_ROOT . '/');
    }
}

function onlyGuest()
{
    if (isset($_SESSION['user']['id'])){
        redirect(APP_ROOT . '/home.php');
    }
}