<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zadania</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1>Moje zadania</h1>

    <p>
        <a href="export_json.php">Eksport JSON</a> |
        <a href="export_csv.php">Eksport CSV</a> |
        <a href="export_xml.php">Eksport XML</a> |
        <a href="import_json.php">Import JSON</a>
    </p>

    <p>
        <a href="task_create.php">Dodaj zadanie</a>
    </p>

    <form method="GET">
        <input type="text" name="search"
            placeholder="Szukaj zadania..."
            value="<?= htmlspecialchars($search ?? '') ?>">

        <button type="submit">Szukaj</button>

    </form>

    <br>

    <table border="1" cellpadding="10">

        <tr>
            <th>Tytuł</th>
            <th>Priorytet</th>
            <th>Termin</th>
            <th>Status</th>
            <th>Projekty</th>
            <th>Załączniki</th>
            <th>Akcje</th>
        </tr>

        <?php if (empty($tasks)): ?>

        <tr>
            <td colspan="6">
                Nie znaleziono żadnych zadań.
            </td>
        </tr>

        <?php endif; ?>

        <?php foreach ($tasks as $task): ?>

            <tr>

                <td><?= htmlspecialchars($task['title']) ?></td>

                <td><?= htmlspecialchars($task['priority']) ?></td>

                <td><?= htmlspecialchars($task['due_date']) ?></td>

                <td>
                    <?= $task['is_completed'] ? 'Ukończone' : 'W trakcie' ?>
                </td>

                <td>
                    <?php
                    $projectsForTask = $taskProjects[$task['id']] ?? [];

                    foreach ($projectsForTask as $project) {
                        echo htmlspecialchars($project['name']) . '<br>';
                    }
                    
                    ?>
                </td>

                <td>
                    <?php
                    $attachments = $taskAttachments[$task['id']] ?? [];

                    foreach ($attachments as $attachment) {

                        echo '<a href="../uploads/' .
                            htmlspecialchars($attachment['file_path']) .
                            '" target="_blank">';

                        echo htmlspecialchars($attachment['file_name']);

                        echo '</a><br>';
                    }
                    ?>
                </td>

                <td>
                    <a href="task_edit.php?id=<?= $task['id'] ?>">Edytuj</a>
                    |
                    <a href="task_delete.php?id=<?= $task['id'] ?>" onclick="return confirm('Czy na pewno usunąć zadanie?')">Usuń</a>
                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <br>

    <a href="dashboard.php">Powrót</a>

</div>

</body>
</html>