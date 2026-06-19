<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($project['name']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1><?= htmlspecialchars($project['name']) ?></h1>

    <p>
        <?= nl2br(htmlspecialchars($project['description'])) ?>
    </p>

    <p>
        Postęp: <?= $progress ?>%
    </p>

    <progress value="<?= $progress ?>" max="100"></progress>

    <hr>

    <h2>Zadania</h2>

    <?php if (empty($tasks)): ?>

        <p>Brak przypisanych zadań.</p>

    <?php else: ?>

        <ul>

            <?php foreach ($tasks as $task): ?>

                <li>

                    <?= $task['is_completed'] ? '✅' : '⬜' ?>

                    <?= htmlspecialchars($task['title']) ?>

                </li>

            <?php endforeach; ?>

        </ul>

    <?php endif; ?>

    <p>
        <a href="projects.php">← Powrót do projektów</a>
    </p>

</div>

</body>
</html>