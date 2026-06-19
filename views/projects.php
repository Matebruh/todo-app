<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Projekty</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1>Moje projekty</h1>

    <p>
        <a href="project_create.php">Dodaj projekt</a>
    </p>

    <table border="1" cellpadding="10">

        <tr>
            <th>Nazwa</th>
            <th>Opis</th>
            <th>Postęp</th>
            <th>%</th>
            <th>Akcje</th>
        </tr>

        <?php foreach ($projects as $project): ?>

            <tr>

                <td>
                    <a href="project_show.php?id=<?= $project['id'] ?>">
                        <?= htmlspecialchars($project['name']) ?>
                    </a>
                </td>

                <td><?= htmlspecialchars($project['description']) ?></td>

                <?php $progress = $projectModel->getProgress($project['id']); ?>
                <td>
                    <progress value="<?= $progress ?>" max="100"></progress>
                </td>

                <td><?= $progress ?>%</td>

                <td>
                    <a href="project_edit.php?id=<?= $project['id'] ?>">Edytuj</a>

                    |

                    <a
                        href="project_delete.php?id=<?= $project['id'] ?>"
                        onclick="return confirm('Czy na pewno usunąć projekt?')">
                        Usuń
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

    <br>

    <a href="dashboard.php">Powrót</a>

</div>

</body>
</html>