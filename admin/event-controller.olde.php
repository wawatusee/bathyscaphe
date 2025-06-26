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
    $event = $eventData['event'] ?? null;

    // Débogage : afficher les valeurs de $event
    error_log(print_r($event, true)); // Écrit dans les journaux du serveur

    if ($event === null || !isset($event['id'])) {
        echo json_encode(["success" => false, "message" => "Données de l'événement invalides ou ID manquant"]);
        exit;
    }
}