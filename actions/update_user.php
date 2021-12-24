<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$userId = $_POST['id'];
$name = $_POST['name'];
$login = $_POST['login'];
$cityId = $_POST['city_id'];

$query = "UPDATE users SET name = :name, city_id = :city_id, login = :login WHERE id = :id";
$res = $pdo->prepare($query);
$status = $res->execute([
    ':id' => $userId,
    ':login' => $login,
    ':name' => $name,
    ':city_id' => $cityId,
]);

if (!$status) {
    $error = $res->errorInfo()[2];
    $_SESSION['error'] = $error;
} else {
    $_SESSION['success'] = true;
}

header("Location: ../pages/user.php?id=$userId");