<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/User.php';

$db = (new Database())->getConnection();

$userModel = new User($db);

if ($_SESSION['user_role'] !== 'admin') {
    die('Brak dostępu.');
}

$users = $userModel->getActivityStats();

require '../views/admin.php';