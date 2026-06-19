<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Task.php';

$db = (new Database())->getConnection();

$taskModel = new Task($db);

$tasks = $taskModel->exportByUser($_SESSION['user_id']);

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="tasks.json"');

echo json_encode(
    $tasks,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
);