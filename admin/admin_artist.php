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
<?php
echo "<pre>";
print_r($artistsData);  // Vérifie la structure de l'objet PHP avant de le transmettre à JavaScript
echo "</pre>";
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
        <form id="artist-form" method="POST" enctype="multipart/form-data"></form>
        <button type="button" id="save-button">Save</button> <!-- Doit être hors du formulaire -->

    </div>

    <script src="js/artist-admin.js"></script>

    <script id="db_json">
        const db_json = <?php echo json_encode($artistsData); ?>;
        console.log("Contenu de db_json:", db_json); // Ajout de la ligne pour afficher la structure dans la console
    </script>


    <script>
        window.onload = function () {
            // Vérifier si db_json et db_json.artist existent et ne sont pas null
            if (db_json && db_json.artist) {
                console.log("Données de l'artiste:", db_json.artist);  // Vérification dans la console
                generateForm(db_json.artist, null); // Passer l'objet "artist" du JSON pour générer le formulaire
            } else {
                console.error("L'objet 'artist' est manquant ou mal formaté dans db_json.");
            }
        };
    </script>

</body>

</html>