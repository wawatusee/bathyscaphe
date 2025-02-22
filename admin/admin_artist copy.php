<?php
// Vérifie si un fichier est spécifié dans l'URL
if (!isset($_GET["file"]) || empty($_GET["file"])) {
    die("Erreur : Aucun fichier d'artiste spécifié !");
}

$artistFile = "../json/artists/" . basename($_GET["file"]); // Sécurise le chemin

// Vérifie l'existence du fichier
if (file_exists($artistFile)) {
    $jsonContent = file_get_contents($artistFile);
    $artistData = json_decode($jsonContent, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Erreur JSON : " . json_last_error_msg());
    }
} else {
    die("Erreur : Fichier artiste introuvable !");
}



// Charger la configuration du formulaire
$formConfig = json_decode(file_get_contents("../json/artist-config.json"), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Artiste</title>
    <link rel="stylesheet" href="css/artist-admin.css">
</head>
<body>
    <h1>Gestion de l'Artiste</h1>
    <div id="form-container">
        <form id="artist-form" method="POST" enctype="multipart/form-data"></form>
        <button type="button" id="save-button">Save</button>
    </div>

    <script src="js/artist-admin.js"></script>

    <script id="db_json">
        const db_json = <?php echo json_encode($artistData); ?>;
        console.log("Contenu de db_json:", db_json);
    </script>

    <script>
        window.onload = function () {
            if (db_json && db_json.artist) {
                generateForm(db_json.artist, null);
            } else {
                console.error("Erreur : Données de l'artiste introuvables !");
            }
        };
    </script>
</body>
</html>
