<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/activity.css">
    <title>Upload d'image pour l'activité</title>
</head>
<body>
    <?php
    $activityId = $_GET['id']; // Récupère l'ID de l'activité depuis l'URL
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    ?>
    <h2 class='consigne-titre'>Upload d'image pour l'activité <?=$activityId?></h2>
    <form action="activity-img.php?id=<?php echo $activityId; ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="activity-image" accept="image/*" required>
        <input type="submit" name="submit" value="Uploader l'image">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        // Vérifier si un fichier a été uploadé
        if ($_FILES['activity-image']['error'] === UPLOAD_ERR_OK) {
            // Vérifier la taille du fichier
            if ($_FILES['activity-image']['size'] > $maxFileSize) {
                echo "Le fichier est trop volumineux. La taille maximale autorisée est de 2MB.";
            } else {
                // Chemin où l'image sera enregistrée
                $targetDir = "../public/img/content/";
                $targetFile = $targetDir . "2024-activity-" . $activityId . ".jpg";
                // Vérification que le fichier est bien une image
                $check = getimagesize($_FILES['activity-image']['tmp_name']);
                if ($check !== false) {
                    // Redimensionner l'image à 400px de large tout en conservant les proportions
                    $sourceImage = imagecreatefromstring(file_get_contents($_FILES['activity-image']['tmp_name']));
                    $originalWidth = $check[0];
                    $originalHeight = $check[1];
                    $newWidth = 400;
                    $newHeight = (400 / $originalWidth) * $originalHeight;
                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                    // Redimensionner l'image
                    $newWidth = (int)$newWidth;
                    $newHeight = (int)$newHeight;
                    $originalWidth = (int)$originalWidth;
                    $originalHeight = (int)$originalHeight;
                    
                    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
                                        // Sauvegarder l'image en .jpg
                    imagejpeg($resizedImage, $targetFile, 90); // Qualité 90
                    // Libérer la mémoire
                    imagedestroy($sourceImage);
                    imagedestroy($resizedImage);
                    header("refresh:3;url=admin.php"); // Remplace "admin-page.php" par l'URL de la page d'administration
                    echo "<div class='consigne'>The image had been uploaded with success.You will be redirected to the activities administration page.</div>";
                    
                } else {
                    echo "<div class='consigne'>This file is not a nice image.</div>";
                }
            }
        } else {
            echo "<div class='consigne'>Error, we've got a situation.</div>";
        }
        
    }
    exit();
    ?>
</body>
</html>
