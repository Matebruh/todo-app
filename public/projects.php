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

$projects = $projectModel->getAllByUser($_SESSION['user_id']);

require '../views/projects.php';