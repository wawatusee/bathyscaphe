<?php
header("Content-Type: application/json");
// Vérifie si des données ont été envoyées en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données JSON depuis le corps de la requête
    $json_data = file_get_contents("php://input");
    $artistData = json_decode($json_data, true);

    if ($artistData === null) {
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }

    // Définir le chemin du fichier JSON (ajuster selon l'ID de l'artiste)
    $artistId = $artistData['id'];
    $filePath = "../json/artists/artist_{$artistId}.json";

    // Enregistrer les données dans le fichier JSON
    if (file_put_contents($filePath, json_encode(["artist" => $artistData], JSON_PRETTY_PRINT))) {
        echo json_encode(["success" => true, "message" => "Données enregistrées"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'enregistrement"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}
