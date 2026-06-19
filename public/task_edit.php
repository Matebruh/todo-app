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

$id = (int) ($_GET['id'] ?? 0);

$selectedProjectIds = $projectModel->getProjectIdsForTask($id);
$attachments = $attachmentModel->getByTask($id);

$task = $taskModel->findByUser($id, $_SESSION['user_id']);

if (!$task) {
    die('Nie znaleziono zadania.');
}

$errors = [];
$old = $task;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST;

    $selectedProjectIds = $_POST['projects'] ?? [];

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
        $taskModel->update($id, [
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'due_date' => $dueDate ?: null,
            'is_completed' => $isCompleted
        ]);

        $selectedProjects = $_POST['projects'] ?? [];

        $projectModel->assignToTask(
            $id,
            $selectedProjects
        );

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
                    'task_id' => $id,
                    'file_name' => $originalName,
                    'file_path' => $fileName
                ]);
            }
        }

        $logModel->create(
            $_SESSION['user_id'],
            'Zaktualizowano zadanie'
        );

        header('Location: tasks.php');
        exit;
    }
}

require '../views/task_form.php';