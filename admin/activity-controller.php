<?php
// Vérifie si des données ont été envoyées en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données JSON depuis le corps de la requête
    $json_data = file_get_contents("php://input");

    // Convertit les données JSON en tableau associatif
    $data = json_decode($json_data, true);
}
// Vérifie si la conversion JSON a réussi
if ($data !== null) {
    // Accédez aux données directement
    $dbJsonActivitytxt = $data;
    // Extraie l'ID du JSON (vérifie que la clé 'id' existe dans le JSON)
    $activityId = isset($data['id']) ? $data['id'] : '';

    // Vérifiez si l'ID est valide
    if (!empty($activityId)) {
        // Construie la destination et le nom du fichier en utilisant l'ID
        $filename = '../json/activities/2024/2024-activity-' . $activityId . '.json';

        // Enregistre le contenu JSON dans le fichier sur le serveur
        file_put_contents($filename, $json_data);

        // Renvoyer une réponse JSON si nécessaire
        $response = ['success' => true, 'message' => $json_data, 'filename' => $filename];
        echo json_encode($response);
    } else {
        // L'ID est manquant ou invalide
        $response = ['success' => false, 'message' => 'ID manquant ou invalide'];
        echo json_encode($response);
    }
} else {
    // La conversion JSON a échoué
    $response = ['success' => false, 'message' => 'Erreur lors de la conversion JSON'];
    echo json_encode($response);
}
