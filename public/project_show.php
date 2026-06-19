<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Project.php';
require_once '../src/Models/Task.php';

$db = (new Database())->getConnection();

$projectModel = new Project($db);
$taskModel = new Task($db);

$id = (int) ($_GET['id'] ?? 0);

$project = $projectModel->findByUser(
    $id,
    $_SESSION['user_id']
);

if (!$project) {
    die('Projekt nie istnieje.');
}

$tasks = $taskModel->getTasksByProject($id);

$progress = $projectModel->getProgress($id);

require '../views/project_show.php';