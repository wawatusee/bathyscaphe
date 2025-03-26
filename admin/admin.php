<?php
include 'session_management.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Tableau de Bord Admin</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="admin_artists.php">Gérer les Artistes</a></li>
                <li><a href="admin_events.php">Gérer les Événements</a></li>
                <!-- Ajoute d'autres liens d'administration ici -->
            </ul>
        </nav>
        <div class="admin-content">
            <!-- Contenu spécifique à l'administration -->
            <p>Bienvenue sur le tableau de bord d'administration. Sélectionnez une section à gérer.</p>
        </div>
    </div>
</body>
</html>
