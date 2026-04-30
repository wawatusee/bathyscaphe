<?php
require_once('../config/config.php');

ob_start(); // Capture toute sortie accidentelle
$response = ['success' => false];

try {
    $galleryName = $_POST['galleryName'] ?? null;

    if (!$galleryName) {
        throw new Exception("Aucun nom de galerie fourni.");
    }

    $thumbsPath = $repImg . 'galleries/' . $galleryName . '/thumbs';

    if (!is_dir($thumbsPath)) {
        throw new Exception("Le répertoire des miniatures n'existe pas.");
    }

    $thumbnails = array_diff(scandir($thumbsPath), ['.', '..']);
    $thumbnailsData = [];

    foreach ($thumbnails as $thumbnail) {
        $thumbnailPath = $thumbsPath . '/' . $thumbnail;

        if (is_file($thumbnailPath)) {
            $thumbnailsData[] = [
                'name' => $thumbnail,
                'url' => IMG_URL . 'content/galleries/' . $galleryName . '/thumbs/' . $thumbnail,
            ];
        }
    }

    $response = [
        'success' => true,
        'thumbnails' => $thumbnailsData,
    ];
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
    ];
}

ob_end_clean(); // Supprimer tout contenu indésirable

// Encode en JSON et capture les erreurs
try {
    echo json_encode($response, JSON_THROW_ON_ERROR | JSON_PARTIAL_OUTPUT_ON_ERROR);
} catch (JsonException $jsonError) {
    echo json_encode([
        'success' => false,
        'error' => 'Erreur d\'encodage JSON : ' . $jsonError->getMessage(),
    ]);
}
exit;
