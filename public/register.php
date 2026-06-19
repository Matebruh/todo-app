<?php

session_start();

require_once '../config/Database.php';
require_once '../src/Models/User.php';
require_once '../src/Services/AuthService.php';

$db = (new Database())->getConnection();

$userModel = new User($db);
$auth = new AuthService($userModel);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!$name || !$email || !$password) {
        $error = 'Wypełnij wszystkie pola';
    } else {

        try {

            $auth->register($name, $email, $password);

            header('Location: login.php');
            exit;

        } catch (Exception $e) {
            $error = 'Email już istnieje';
        }
    }
}

require '../views/register.php';