<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Import JSON</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1>Import zadań z JSON</h1>

    <?php foreach ($errors as $error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <?php if ($success): ?>
        <p><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="file" name="json_file" accept=".json" required>

        <br><br>

        <button type="submit">Importuj</button>

    </form>

    <br>

    <a href="tasks.php">Powrót</a>

</div>

</body>
</html>