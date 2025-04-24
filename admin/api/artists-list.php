<?php
$artistDir = '../../json/artists/';
$artistFiles = glob($artistDir . 'a[0-9][0-9][0-9].json'); // stricte : a + 3 chiffres
$artistList = [];
foreach ($artistFiles as $file) {
    $jsonData = file_get_contents($file);
    if ($jsonData !== false) {
        $data = json_decode($jsonData, true);
        if ($data !== null && isset($data['artist']['id']) && isset($data['artist']['name'])) {
            $artistList[] = [
                'id' => $data['artist']['id'],
                'name' => $data['artist']['name']
            ];
        } else {
            error_log("❌ JSON invalide dans le fichier : $file");
        }
    } else {
        error_log("⚠️ Impossible de lire le fichier : $file");
    }
}
header('Content-Type: application/json');
echo json_encode($artistList);
