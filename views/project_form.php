<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Projekt</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1><?= isset($project) ? 'Edytuj projekt' : 'Nowy projekt' ?></h1>

    <?php if (!empty($errors)): ?>

        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>

    <?php endif; ?>

    <form method="POST">

        <label>Nazwa projektu</label>
        <br>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
        <br><br>

        <label>Opis</label>
        <br>
        <textarea name="description" rows="5"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        <br><br>

        <button type="submit">
            <?= isset($project) ? 'Aktualizuj' : 'Zapisz' ?>
        </button>

    </form>

    <br>

    <a href="projects.php">Powrót</a>

</div>

</body>
</html>