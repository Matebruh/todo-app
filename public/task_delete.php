<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Task.php';
require_once '../src/Models/Attachment.php';
require_once '../src/Models/ActivityLog.php';

$db = (new Database())->getConnection();
$taskModel = new Task($db);
$attachmentModel = new Attachment($db);
$logModel = new ActivityLog($db);

$id = (int) ($_GET['id'] ?? 0);

$task = $taskModel->findByUser($id, $_SESSION['user_id']);

if (!$task) {
    die('Nie znaleziono zadania.');
}

$attachments = $attachmentModel->getByTask($id);

foreach ($attachments as $attachment) {

    $filePath = '../uploads/' . $attachment['file_path'];

    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

$taskModel->delete($id);

$logModel->create(
    $_SESSION['user_id'],
    'Usunięto zadanie'
);

header('Location: tasks.php');
exit;