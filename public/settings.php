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

$user = $userModel->find($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sort = $_POST['task_sort'];

    $allowed = [
        'newest',
        'oldest',
        'priority'
    ];

    if (in_array($sort, $allowed)) {

        $userModel->updateSortPreference(
            $_SESSION['user_id'],
            $sort
        );

        header('Location: settings.php');
        exit;
    }
}

require '../views/settings.php';