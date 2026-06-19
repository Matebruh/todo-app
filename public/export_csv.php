<?php

session_start();

require_once '../config/Database.php';
require_once '../src/Models/Task.php';

$db = (new Database())->getConnection();

$taskModel = new Task($db);

$tasks = $taskModel->exportByUser($_SESSION['user_id']);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tasks.csv"');

$output = fopen('php://output', 'w');

fputcsv($output, [
    'id',
    'title',
    'description',
    'priority',
    'is_completed'
]);

foreach ($tasks as $task) {
    fputcsv($output, [
        $task['id'],
        $task['title'],
        $task['description'],
        $task['priority'],
        $task['is_completed']
    ]);
}

fclose($output);