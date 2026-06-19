<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Project.php';

$db = (new Database())->getConnection();

$projectModel = new Project($db);

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old = $_POST;

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name === '') {
        $errors[] = 'Nazwa projektu jest wymagana.';
    }

    if (empty($errors)) {

        $projectModel->create([
            'user_id' => $_SESSION['user_id'],
            'name' => $name,
            'description' => $description
        ]);

        header('Location: projects.php');
        exit;
    }
}

require '../views/project_form.php';