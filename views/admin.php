<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administratora</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Panel administratora</h1>

    <a href="admin_logs.php">
        Logi aktywności
    </a>
    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Imię</th>
            <th>Email</th>
            <th>Rola</th>
            <th>Zadań</th>
            <th>Projektów</th>
            <th>Rejestracja</th>
            <th>Akcje</th>
        </tr>
        <?php foreach ($users as $user): ?>

            <tr>
                <td><?= $user['id'] ?></td>

                <td><?= htmlspecialchars($user['name']) ?></td>

                <td><?= htmlspecialchars($user['email']) ?></td>

                <td><?= htmlspecialchars($user['role']) ?></td>

                <td><?= $user['tasks_count'] ?></td>

                <td><?= $user['projects_count'] ?></td>

                <td><?= $user['created_at'] ?></td>

                <td>

                    <a href="admin_role.php?id=<?= $user['id'] ?>">Zmień rolę</a>

                    <br>

                    <a href="admin_delete_user.php?id=<?= $user['id'] ?>"
                       onclick="return confirm('Usunąć użytkownika?')">
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