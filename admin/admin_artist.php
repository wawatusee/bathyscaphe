<?php
// Charger le fichier JSON des artistes
$artistsData = [];
$artistFile = "../json/artists/artist_1.json";  // Exemple de fichier JSON pour un artiste

if (file_exists($artistFile)) {
    $artistsData = json_decode(file_get_contents($artistFile), true);
} else {
    // Si le fichier n'existe pas, on crée un modèle vide
    $artistsData = [
        "artist" => [
            "id" => "",
            "name" => "",
            "illustration" => "",  // L'illustration sera générée dynamiquement
            "art" => ["en" => "", "fr" => "", "nl" => ""],
            "liens" => []
        ]
    ];
}

// Charger la configuration de formulaire (artist-config.json)
$formConfig = json_decode(file_get_contents("../json/artist-config.json"), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Artistes</title>
    <!-- Importer le fichier CSS -->
    <link rel="stylesheet" href="css/artist-admin.css">
</head>
<body>

    <h1>Gestion des Artistes</h1>

    <div id="form-container">
        <form id="artist-form" method="POST" enctype="multipart/form-data">
            <!-- Le formulaire sera généré dynamiquement avec JS -->
        </form>
    </div>

    <!-- Importer le fichier JavaScript -->
    <script src="js/artist-admin.js"></script>

    <script id="db_json">
        // Passer les données PHP dans une variable JS pour traitement
        const db_json = <?php echo json_encode($artistsData['artist'], JSON_PRETTY_PRINT); ?>;
        const form_config = <?php echo json_encode($formConfig, JSON_PRETTY_PRINT); ?>;
    </script>

    <script>
        // Initialiser la génération du formulaire
        window.onload = function () {
            generateForm(db_json, form_config.artist);
        };
    </script>

</body>
</html>
