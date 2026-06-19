<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ustawienia</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1>Ustawienia</h1>

    <form method="POST">

        <h3>Domyślne sortowanie zadań</h3>

        <select name="task_sort">

            <option value="newest"
                <?= $user['task_sort'] === 'newest' ? 'selected' : '' ?>>
                Najnowsze
            </option>

            <option value="oldest"
                <?= $user['task_sort'] === 'oldest' ? 'selected' : '' ?>>
                Najstarsze
            </option>

            <option value="priority"
                <?= $user['task_sort'] === 'priority' ? 'selected' : '' ?>>
                Priorytet
            </option>

        </select>

        <br><br>

        <button type="submit">Zapisz</button>

    </form>

    <br>

    <a href="dashboard.php">Powrót</a>

</div>

</body>
</html>