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
require_once '../src/Models/ActivityLog.php';


$db = (new Database())->getConnection();

$taskModel = new Task($db);
$projectModel = new Project($db);
$attachmentModel = new Attachment($db);
$logModel = new ActivityLog($db);

$projects = $projectModel->getAllByUser($_SESSION['user_id']);

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old = $_POST;

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $priority = $_POST['priority'] ?? '';
    $dueDate = $_POST['due_date'] ?? '';
    $isCompleted = isset($_POST['is_completed']) ? 1 : 0;

    if ($title === '') {
        $errors[] = 'Tytuł jest wymagany.';
    }

    if (mb_strlen($title) > 255) {
        $errors[] = 'Tytuł może mieć maksymalnie 255 znaków.';
    }

    $allowedPriorities = ['niski', 'średni', 'wysoki'];

    if (!in_array($priority, $allowedPriorities)) {
        $errors[] = 'Nieprawidłowy priorytet.';
    }

    if ($dueDate !== '' && !strtotime($dueDate)) {
        $errors[] = 'Nieprawidłowa data.';
    }

    if (!empty($_FILES['attachments']['name'][0])) {

        $allowedExtensions = [
            'pdf',
            'jpg',
            'jpeg',
            'png',
            'doc',
            'docx'
        ];

        foreach ($_FILES['attachments']['name'] as $index => $fileName) {

            $extension = strtolower(
                pathinfo($fileName, PATHINFO_EXTENSION)
            );

            if (!in_array($extension, $allowedExtensions)) {
                $errors[] = "Niedozwolony typ pliku: $fileName";
            }

            if ($_FILES['attachments']['size'][$index] > 5 * 1024 * 1024) {
                $errors[] = "Plik $fileName jest większy niż 5 MB";
            }
        }
    }

    if (empty($errors)) {
        $taskModel->create([
            'user_id' => $_SESSION['user_id'],
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'due_date' => $dueDate ?: null,
            'is_completed' => $isCompleted
        ]);

        $taskId = $taskModel->getLastInsertId();

        if (!empty($_FILES['attachments']['name'][0])) {

            $uploadDir = '../uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            foreach ($_FILES['attachments']['name'] as $index => $originalName) {

                $fileName = time() . '_' . $originalName;

                $targetPath = $uploadDir . $fileName;

                move_uploaded_file(
                    $_FILES['attachments']['tmp_name'][$index],
                    $targetPath
                );

                $attachmentModel->create([
                    'task_id' => $taskId,
                    'file_name' => $originalName,
                    'file_path' => $fileName
                ]);
            }
        }

        $selectedProjects = $_POST['projects'] ?? [];

        $projectModel->assignToTask(
            $taskId,
            $selectedProjects
        );

        $logModel->create(
            $_SESSION['user_id'],
            'Utworzono nowe zadanie'
        );

        header('Location: tasks.php');
        exit;
    }
}

require '../views/task_form.php';