<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données JSON
    $jsonData = file_get_contents('php://input');
    $artistData = json_decode($jsonData, true);

    // Vérifie si le fichier est spécifié
    if (!isset($artistData['file'])) {
        echo json_encode(['success' => false, 'message' => 'Aucun fichier spécifié !']);
        exit;
    }

    $file = $artistData['file'];
    $artistFile = "../json/artists/" . basename($file);

    // Vérifie l'existence du fichier
    if (!file_exists($artistFile) || !is_writable($artistFile)) {
        echo json_encode(['success' => false, 'message' => 'Fichier introuvable ou non modifiable !']);
        exit;
    }

    // Extraire l'ID et le nom de l'artiste
    $artistId = $artistData['artist']['id'];
    $artistName = strtolower(str_replace(' ', '-', $artistData['artist']['name']));

    // Construire le nouveau nom de fichier
    $newFileName = "../json/artists/{$artistId}_{$artistName}.json";

    // Convertir les données en JSON et les sauvegarder dans le nouveau fichier
    $jsonContent = json_encode($artistData, JSON_PRETTY_PRINT);
    if (file_put_contents($newFileName, $jsonContent) !== false) {
        // Supprimer l'ancien fichier si le nouveau a été créé avec succès
        unlink($artistFile);
        echo json_encode(['success' => true, 'message' => 'Données sauvegardées avec succès !']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la sauvegarde des données !']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée !']);
}
