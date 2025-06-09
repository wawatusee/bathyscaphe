<?php
require_once "../src/utils/image_uploader.php";

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['thumbnail'])) {
    $artistId = $_POST['artist_id'];
    $uploadDir = "../public/img/content/artists/";
    $uploader = new ImageUploader($uploadDir);

    try {
        $imageName = $uploader->uploadAndResize($_FILES['thumbnail'], $artistId);
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
        <h1>Télécharger une image pour l'artiste</h1>

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
            <input type="hidden" name="artist_id" value="<?= htmlspecialchars($_POST['artist_id']) ?>">
            <button type="submit" class="btn">Télécharger</button>
        </form>
        <a href="admin_artists.php" class="btn-back">Retour à la liste des artistes</a>
    </div>
</body>
</html>
