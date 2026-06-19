<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

<h1>Witaj <?= htmlspecialchars($_SESSION['user_name']) ?></h1>

<p>Rola: <?= $_SESSION['user_role'] ?></p>

<?php if ($_SESSION['user_role'] === 'admin'): ?>

    <br><br>

    <a href="admin.php">
        Panel administratora
    </a>

<?php endif; ?>

<p>
    <a href="tasks.php">Moje zadania</a>

    <br><br>

    <a href="projects.php">Moje projekty</a>
</p>

<p>
    <a href="settings.php">Ustawienia</a>
</p>

<p>
    <a href="logout.php">Wyloguj</a>
</p>

</div>

</body>
</html>