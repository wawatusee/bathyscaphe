<?php
require_once('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_start(); // Démarre la capture du tampon
    $response = ['success' => false]; // Réponse par défaut

    try {
        $galleryName = $_POST['galleryName'] ?? null;
        $imageName = $_POST['imageName'] ?? null;

        if (!$galleryName || !$imageName) {
            throw new Exception('Paramètres manquants.');
        }

        $originalPath = $repImg . 'galleries/' . $galleryName . '/original/' . $imageName;
        $thumbPath = $repImg . 'galleries/' . $galleryName . '/thumbs/' . $imageName;

        if (file_exists($originalPath)) {
            unlink($originalPath);
        }

        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }

        $response = [
            'success' => true,
            'message' => "L'image $imageName a été supprimée.",
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'error' => $e->getMessage(),
        ];
    }

    ob_end_clean(); // Nettoie tout contenu non désiré dans le tampon

    try {
        echo json_encode($response, JSON_THROW_ON_ERROR | JSON_PARTIAL_OUTPUT_ON_ERROR);
    } catch (JsonException $jsonError) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur d\'encodage JSON : ' . $jsonError->getMessage(),
        ]);
    }
    exit;
}