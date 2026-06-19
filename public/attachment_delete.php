<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/Database.php';
require_once '../src/Models/Attachment.php';

$db = (new Database())->getConnection();

$attachmentModel = new Attachment($db);

$id = (int) ($_GET['id'] ?? 0);

$attachment = $attachmentModel->find($id);

if (!$attachment) {
    die('Nie znaleziono załącznika.');
}

$filePath = '../uploads/' . $attachment['file_path'];

if (file_exists($filePath)) {
    unlink($filePath);
}

$attachmentModel->delete($id);

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'tasks.php'));
exit;