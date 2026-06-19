<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Task.php';
require_once '../src/Models/Project.php';
require_once '../src/Models/Attachment.php';
require_once '../src/Models/User.php';

$db = (new Database())->getConnection();

$taskModel = new Task($db);
$projectModel = new Project($db);
$attachmentModel = new Attachment($db);
$userModel = new User($db);

$user = $userModel->find($_SESSION['user_id']);

$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $tasks = $taskModel->searchByUser(
        $_SESSION['user_id'],
        $search
    );
} else {
    $tasks = $taskModel->getAllByUser($_SESSION['user_id']);
}

$taskProjects = [];

foreach ($tasks as $task) {

    $taskProjects[$task['id']] =
        $projectModel->getProjectsForTask($task['id']);
}

$taskAttachments = [];

foreach ($tasks as $task) {

    $taskAttachments[$task['id']] =
        $attachmentModel->getByTask($task['id']);
}

require '../views/tasks.php';