<?php
// Afficher les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'ImageUploader.php';

header('Content-Type: application/json');

$response = array('success' => false, 'error' => '');

try {
    $uploadDir = $_POST['uploadDir'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $imageFormat = $_POST['imageFormat'];

    // Vérifiez si les fichiers ont bien été téléchargés
    if (!isset($_FILES['images'])) {
        throw new Exception("No files uploaded");
    }

    // Extraire les noms des fichiers sans extension
    $imageNames = array();
    foreach ($_FILES['images']['name'] as $key => $name) {
        $imageNames[] = pathinfo($name, PATHINFO_FILENAME);
    }

    // Boucle pour traiter chaque fichier téléchargé
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $uploader = new ImageUploader($uploadDir, $width, $height, $imageNames[$key], $imageFormat);
        $uploader->upload([
            'name' => $_FILES['images']['name'][$key],
            'type' => $_FILES['images']['type'][$key],
            'tmp_name' => $tmpName,
            'error' => $_FILES['images']['error'][$key],
            'size' => $_FILES['images']['size'][$key],
        ]);
    }

    $response['success'] = true;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>
