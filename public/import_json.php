<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Task.php';

$db = (new Database())->getConnection();
$taskModel = new Task($db);

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['json_file']) || $_FILES['json_file']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Wybierz plik JSON.';
    }

    if (empty($errors)) {

        $content = file_get_contents($_FILES['json_file']['tmp_name']);

        $tasks = json_decode($content, true);

        if (!is_array($tasks)) {
            $errors[] = 'Nieprawidłowy format JSON.';
        }

        if (empty($errors)) {

            foreach ($tasks as $task) {

                if (empty(trim($task['title'] ?? ''))) {
                    continue;
                }

                $taskModel->create([
                    'user_id' => $_SESSION['user_id'],
                    'title' => $task['title'],
                    'description' => $task['description'] ?? '',
                    'priority' => $task['priority'] ?? 'medium',
                    'due_date' => $task['due_date'] ?? null,
                    'is_completed' => $task['is_completed'] ?? 0
                ]);
            }

            $success = 'Import zakończony pomyślnie.';
        }
    }
}

require '../views/import_json.php';