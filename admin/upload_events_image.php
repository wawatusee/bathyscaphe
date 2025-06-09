<?php
require_once "../src/utils/image_uploader.php";

$message = "";
$messageClass = "";
$event_id = "";

// Récupérer l'ID de l'événement, que ce soit de la soumission initiale ou de la soumission du formulaire
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
}

// Traiter l'upload si un fichier a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] != 4) {
    $uploadDir = "../public/img/content/events/";
    $uploader = new ImageUploader($uploadDir);

    try {
        $imageName = $uploader->uploadAndResize($_FILES['thumbnail'], $event_id);
        $message = "Image téléchargée et redimensionnée avec succès !";
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
    <title>Télécharger une image</title>
    <link rel="stylesheet" href="css/upload-image.css">
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
            </div>
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($event_id) ?>">
            <button type="submit" class="btn">Télécharger</button>
        </form>
        <a href="admin_events.php" class="btn-back">Retour à la liste des événements</a>
    </div>
</body>
</html>