<?php

session_start();

require_once '../config/Database.php';
require_once '../src/Models/User.php';

$db = (new Database())->getConnection();

$userModel = new User($db);

if ($_SESSION['user_role'] !== 'admin') {
    die('Brak dostępu.');
}

$id = (int) ($_GET['id'] ?? 0);

$user = $userModel->find($id);

if (!$user) {
    die('Nie znaleziono użytkownika.');
}

$newRole = $user['role'] === 'admin'
    ? 'user'
    : 'admin';

$userModel->updateRole($id, $newRole);

header('Location: admin.php');
exit;