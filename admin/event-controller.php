<?php
header("Content-Type: application/json");

// Vérifie si des données ont été envoyées en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données JSON depuis le corps de la requête
    $json_data = file_get_contents("php://input");
    $eventData = json_decode($json_data, true);

    if ($eventData === null) {
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }

    // Accéder aux données de l'événement
    $event = $eventData['event'];
    error_log(print_r($event, true));

    // Définir le chemin du fichier JSON (ajuster selon l'ID de l'événement)
    $eventId = $event["event"]["id"];
    $filePath = "../json/events/n" . (string)$eventId . ".json";

    // Enregistrer les données dans le fichier JSON
    if (file_put_contents($filePath, json_encode($event, JSON_PRETTY_PRINT))) {
        echo json_encode(["success" => true, "message" => "Événement sauvegardé !"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'enregistrement"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
}