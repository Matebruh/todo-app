<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Nowe zadanie</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

    <h1><?= isset($task) ? 'Edytuj zadanie' : 'Dodaj zadanie' ?></h1>

    <?php if (!empty($errors)): ?>

        <div>

            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <label>Tytuł</label>
        <br>
        <input type="text" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>">
        <br><br>

        <label>Opis</label>
        <br>
        <textarea name="description" rows="5"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
        <br><br>

        <label>Priorytet</label>
        <br>

        <select name="priority">

            <option value="niski" <?= ($old['priority'] ?? '') === 'niski' ? 'selected' : '' ?>>
                Niski
            </option>

            <option value="średni" <?= ($old['priority'] ?? 'średni') === 'średni' ? 'selected' : '' ?>>
                Średni
            </option>

            <option value="wysoki" <?= ($old['priority'] ?? '') === 'wysoki' ? 'selected' : '' ?>>
                Wysoki
            </option>

        </select>

        <br><br>

        <label>Termin wykonania</label>
        <br>
        <input type="date" name="due_date" value="<?= htmlspecialchars($old['due_date'] ?? '') ?>">
        <br><br>

        <label>
            <input type="checkbox" name="is_completed" value="1"
                <?= !empty($old['is_completed']) ? 'checked' : '' ?>>
            Zadanie ukończone
        </label>

        <br><br>

        <label>Projekty</label>

        <br>

        <?php foreach ($projects as $project): ?>
        
            <label>
                <input 
                    type="checkbox" name="projects[]" 
                    value="<?= $project['id'] ?>"
                    <?= in_array($project['id'], $selectedProjectIds ?? []) ? 'checked' : '' ?>
                >

                <?= htmlspecialchars($project['name']) ?>
            </label>
        
        <br>
        
        <?php endforeach; ?>
        
        <br>

        <label>Załącznik</label>
        <br>
        <input type="file" name="attachments[]" multiple>

            <?php if (!empty($attachments)): ?>
                <p>Obecne załączniki:</p>
                <?php foreach ($attachments as $attachment): ?>
                    <a href="../uploads/<?= htmlspecialchars($attachment['file_path']) ?>" target="_blank">
                        <?= htmlspecialchars($attachment['file_name']) ?>
                    </a>

                    <a href="attachment_delete.php?id=<?= $attachment['id'] ?>"
                    onclick="return confirm('Usunąć załącznik?')">
                        Usuń
                    </a>

                    <br>
                <?php endforeach; ?>
            <?php endif; ?>

        <br><br>

        <button type="submit"><?= isset($task) ? 'Aktualizuj' : 'Zapisz' ?></button>

    </form>

    <br>

    <a href="tasks.php">Powrót do listy</a>

</div>

</body>
</html>