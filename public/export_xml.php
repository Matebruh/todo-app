<?php

session_start();

require_once '../config/Database.php';
require_once '../src/Models/Task.php';

$db = (new Database())->getConnection();

$taskModel = new Task($db);

$tasks = $taskModel->exportByUser($_SESSION['user_id']);

$xml = new SimpleXMLElement('<tasks/>');

foreach ($tasks as $task) {

    $taskNode = $xml->addChild('task');

    $taskNode->addChild('title', htmlspecialchars($task['title']));
    $taskNode->addChild('description', htmlspecialchars($task['description']));
    $taskNode->addChild('priority', $task['priority']);
    $taskNode->addChild('completed', $task['is_completed']);
}

header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="tasks.xml"');

echo $xml->asXML();