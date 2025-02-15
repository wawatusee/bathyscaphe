<?php
$directory = "../json/artists/"; // Dossier contenant les fichiers JSON

// Vérifier si le dossier existe
if (!is_dir($directory)) {
    die("Erreur : Le répertoire des artistes n'existe pas !");
}

// Récupérer tous les fichiers JSON
$files = glob($directory . "*.json");

// Vérifier si des fichiers sont trouvés
if (!$files) {
    die("Aucun artiste trouvé.");
}

// Préparer la liste des artistes en extrayant les infos des noms de fichiers
$artists = [];

foreach ($files as $file) {
    if (basename($file) === "config.json") {
        continue; // Ignorer le fichier de configuration
    }
    $filename = basename($file, ".json"); // Supprimer l'extension .json
    if (preg_match('/^([a-z0-9]+)_(.+)$/i', $filename, $matches)) {
        $artists[] = [
            "id" => $matches[1],  // ID extrait
            "name" => str_replace("_", " ", $matches[2]), // Nom avec espaces à la place des _
            "file" => basename($file)
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des artistes</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <?php require_once "admin_artists_header.php";?>
    <h1>Liste des artistes</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Fichier</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($artists as $artist) : ?>
                <tr>
                    <td><?= htmlspecialchars($artist["id"]) ?></td>
                    <td><?= htmlspecialchars($artist["name"]) ?></td>
                    <td><?= htmlspecialchars($artist["file"]) ?></td>
                    <td>
                        <a href="admin_artist.php?id=<?= urlencode($artist["id"]) ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
