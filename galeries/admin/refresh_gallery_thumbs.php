<?php
require_once('../src/model/gallery_model.php');
require_once('image_uploader.class.php');
require_once('../config/config.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'error' => ''];

try {
    $galleryName = $_POST['galleryName'] ?? null;

    if (!$galleryName) {
        throw new Exception("Aucun nom de galerie fourni.");
    }

    $originalPath = $repImg . 'galleries/' . $galleryName . '/original';
    $thumbsPath = $repImg . 'galleries/' . $galleryName . '/thumbs';

    // Instancier le modèle de galerie pour obtenir les images
    $gallery = new Model_gallery($originalPath, 'image/jpeg'); 
    $images = $gallery->getImages();

    // Créer le répertoire 'thumbs' s'il n'existe pas
    if (!is_dir($thumbsPath)) {
        mkdir($thumbsPath, 0777, true);
    }

    $processedImages = 0;

    // Parcourir les images pour générer les miniatures
    foreach ($images as $image) {
        $originalFile = $originalPath . '/' . $image['name'];
        $thumbFile = $thumbsPath . '/' . $image['name'];

        // Vérifier si la miniature existe déjà
        if (file_exists($thumbFile)) {
            continue; 
        }

        // Redimensionner l'image
        $uploader = new ImageUploader($thumbsPath); 
        $uploader->resizeToWidth($originalFile, $thumbFile, 400);
        $processedImages++;
    }

    $response['success'] = true;
    $response['message'] = "Miniatures générées avec succès pour la galerie '{$galleryName}' ({$processedImages} nouvelles miniatures).";
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Envoyer la réponse JSON
echo json_encode($response, JSON_THROW_ON_ERROR);