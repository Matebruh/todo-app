<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <h1>Rejestracja</h1>

    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Imię" required>

        <br><br>

        <input type="email" name="email" placeholder="Email" required>

        <br><br>

        <input type="password" name="password" placeholder="Hasło" required>

        <br><br>

        <button type="submit">Zarejestruj</button>
    </form>
</div>

</body>
</html>