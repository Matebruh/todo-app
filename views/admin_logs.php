<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logi aktywności</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Logi aktywności</h1>

        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Użytkownik</th>
                <th>Akcja</th>
                <th>Data</th>
            </tr>

            <?php foreach ($logs as $log): ?>

                <tr>

                    <td><?= htmlspecialchars($log['id']) ?></td>

                    <td><?= htmlspecialchars($log['name']) ?></td>

                    <td><?= htmlspecialchars($log['action']) ?></td>

                    <td><?= $log['created_at'] ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    <br>

    <a href="admin.php">Powrót</a>

</div>

</body>
</html>