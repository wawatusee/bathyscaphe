<?php
$directory = "../json/artists/";

// Vérifier si le dossier existe
if (!is_dir($directory)) {
    die("Erreur : Le répertoire des artistes n'existe pas !");
}

// Récupérer tous les fichiers JSON (sauf config.json)
$files = glob($directory . "a*.json");
$artists = [];

// Déterminer le dernier ID utilisé
$maxId = 0;

foreach ($files as $file) {
    $filename = basename($file); // Récupère le nom du fichier (ex: "a001.json")
    
    // Vérifier si le fichier correspond au format "a001.json"
    if (preg_match('/^a(\d{3})\.json$/', $filename, $matches)) {
        $id = (int)$matches[1]; // Récupère l'ID (ex: 1 pour "a001.json")

        // Ajouter l'artiste au tableau
        $artists[] = [
            "id" => $id,
            "file" => $filename
        ];

        // Mettre à jour le dernier ID utilisé
        if ($id > $maxId) {
            $maxId = $id;
        }
    }
}

// Générer le prochain ID disponible avec padding
$newId = "a" . str_pad($maxId + 1, 3, "0", STR_PAD_LEFT);

// Création d'un nouvel artiste si bouton cliqué
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newArtistFile = $directory . $newId . ".json"; // Format : a001.json
    $newArtistData = [
        "artist" => [
            "id" => $newId,
            "name" => "Nouvel Artiste",
            "illustration" => "",
            "art" => ["en" => "", "fr" => "", "nl" => ""],
            "description" => ["en" => "", "fr" => "", "nl" => ""],
            "liens" => []
        ]
    ];

    // Sauvegarde du fichier JSON
    file_put_contents($newArtistFile, json_encode($newArtistData, JSON_PRETTY_PRINT));

    // Redirection vers la page de modification avec le bon fichier
    header("Location: admin_artist.php?file=" . urlencode(basename($newArtistFile)));
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des artistes</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/admin-artists.css">

</head>
<body>
    <h1>Liste des artistes</h1>

    <form method="POST">
        <button type="submit" class="btn">+ Ajouter un artiste</button>
    </form>

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
                    <td><?= htmlspecialchars("a" . str_pad($artist["id"], 3, "0", STR_PAD_LEFT)) ?></td>
                    <td><?= htmlspecialchars($artist["name"]) ?></td>
                    <td><?= htmlspecialchars($artist["file"]) ?></td>
                    <td>
                        <a href="admin_artist.php?file=<?= urlencode($artist["file"]); ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
