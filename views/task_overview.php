<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâche #<?php echo $task['id']; ?></title>
</head>
<body>
<h1><?php echo 'tache ' . $task['id'] . ' : ' . $task['title']; ?></h1>
<p><a href="/DemoMVCAlpha/tasks">Retour à la liste</a></p>
</body>
</html>
