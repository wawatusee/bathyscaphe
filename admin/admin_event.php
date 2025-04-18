<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'session_management.php';

$file = isset($_GET['file']) ? htmlspecialchars(trim($_GET['file'])) : '';
// Vérifie si un fichier est spécifié dans l'URL
/*$file = filter_input(INPUT_GET, 'file', FILTER_SANITIZE_STRING);*/
//var_dump($file);
if (!$file) {
    die("Erreur : Aucun fichier d'événement spécifié !");
}

$eventFile = "../json/events/" . basename($file);
var_dump($eventFile);
// Vérifie l'existence du fichier
if (!file_exists($eventFile) || !is_readable($eventFile)) {
    die("Erreur : Fichier événement introuvable !");
}

$jsonContent = file_get_contents($eventFile);
$eventData = json_decode($jsonContent, true);
var_dump($eventData);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erreur JSON : " . json_last_error_msg());
}

$formConfig = json_decode(file_get_contents("../json/event-config.json"), true);
if (!file_exists($formConfig) || !is_readable($formConfig)) {
    die("Erreur : Fichier config introuvable !");
}
var_dump($formConfig);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Événement</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/admin-artist.css">
</head>
<body>
    <header>
        <h1>Gestion de l'Événement</h1>
        <a href="admin_events.php"><button class="btn-back">Retour à la liste</button></a>
    </header>
    <div id="form-container">
        <div id="event-form"></div>
        <button type="button" id="save-button">Save</button>
    </div>

    <script>
        const formConfig = <?php echo json_encode($formConfig); ?>;
        const eventData = <?php echo json_encode($eventData); ?>;
    </script>
    <script src="js/event-admin.js"></script>
</body>
</html>
