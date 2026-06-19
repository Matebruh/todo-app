<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SESSION['user_role'] !== 'admin') {
    die('Brak dostępu.');
}

require_once '../config/Database.php';
require_once '../src/Models/ActivityLog.php';

$db = (new Database())->getConnection();

$logModel = new ActivityLog($db);

$logs = $logModel->getAll();

require '../views/admin_logs.php';