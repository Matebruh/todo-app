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

if ($id === $_SESSION['user_id']) {
    die('Nie możesz usunąć własnego konta.');
}

$userModel->delete($id);

header('Location: admin.php');
exit;