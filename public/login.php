<?php

session_start();

require_once '../config/Database.php';
require_once '../src/Models/User.php';
require_once '../src/Services/AuthService.php';
require_once '../src/Models/ActivityLog.php';

$db = (new Database())->getConnection();

$userModel = new User($db);
$auth = new AuthService($userModel);
$logModel = new ActivityLog($db);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$auth->login($email, $password)) {
        $error = 'Nieprawidłowe dane logowania';
    } else {
        
        $logModel->create(
            $_SESSION['user_id'],
            'Zalogowano do systemu'
        );

        header('Location: dashboard.php');
        exit;
    }
}

require '../views/login.php';