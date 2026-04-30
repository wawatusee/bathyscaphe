<?php
require_once "../src/utils/image_uploader.php";

$message = "";
$messageClass = "";
$event_id = "";

// Récupérer l'ID de l'événement, que ce soit de la soumission initiale ou de la soumission du formulaire
if (isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']); // Assurez-vous que c'est un entier
}

// Traiter l'upload si un fichier a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] != 4) {
    $uploadDir = "../public/img/content/events/";
    $uploader = new ImageUploader($uploadDir);

    try {
        // Utiliser la nouvelle méthode spécifique aux événements
        $imageResult = $uploader->uploadAndResizeEvent($_FILES['thumbnail'], $event_id);
        $message = "Image téléchargée et redimensionnée avec succès ! Une miniature a également été créée.";
        $messageClass = "success-message";
    } catch (Exception $e) {
        $message = "Erreur lors du téléchargement de l'image : " . $e->getMessage();
        $messageClass = "error-message";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger une image d'événement</title>
    <link rel="stylesheet" href="css/upload-image.css">
    <style>
        .success-message {
            color: green;
            background-color: #e8f5e9;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .error-message {
            color: red;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div id="upload-container">
        <h1>Télécharger une image pour l'événement</h1>

        <?php if ($message): ?>
            <div class="<?= $messageClass ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="field-container">
                <label for="thumbnail">Choisissez une image :</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" required>
                <p class="help-text">L'image sera redimensionnée à 480px de hauteur. Une miniature sera également créée.</p>
            </div>
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($event_id) ?>">
            <button type="submit" class="btn">Télécharger</button>
        </form>
        <a href="admin_events.php" class="btn-back">Retour à la liste des événements</a>
    </div>
</body>
</html>