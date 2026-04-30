<?php
include 'session_management.php';

//Fonction pour parser les artistes
function getArtists() {
    $artists = [];
    $artistDir = '../json/artists';
    
    foreach (glob("$artistDir/a*.json") as $file) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        
        if (isset($data['artist']['id']) && isset($data['artist']['name'])) {
            $artists[$data['artist']['id']] = $data['artist']['name'];
        }
    }
    
    return $artists;
}

//Fonction pour parser les events
function getEvents($artists) {
    $events = [];
    $eventDir = '../json/events';
    
    foreach (glob("$eventDir/n*.json") as $file) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        
        if (isset($data['event']['id']) && isset($data['event']['time']['date']) && isset($data['event']['title'])) {
            $eventArtists = array_map(function($artistId) use ($artists) {
                return $artists[$artistId] ?? 'Unknown Artist';
            }, $data['event']['artists']);
            
            $events[] = [
                "event_id" => $data['event']['id'],
                "date" => $data['event']['time']['date'],
                "title" => $data['event']['title'],
                "artists" => $eventArtists
            ];
        }
    }
    
    return $events;
}

//Function to update JSON
function updateVueEventsJson() {
    $artists = getArtists();
    $events = getEvents($artists);

    $data = [
        "vue-events" => [
            "last-updated" => date('Y-m-d')
        ],
        "events" => $events,    
        "artists"=>$artists
    ];

    // Convertit les données en JSON
    $json_data = json_encode($data, JSON_PRETTY_PRINT);

    // Chemin d'accès au fichier JSON
    $file_path = '../json/vue-events-artists.json';

    // Écriture dans le fichier
    file_put_contents($file_path, $json_data);
}

// Si le bouton refresh est cliqué
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refresh'])) {
    updateVueEventsJson();
}

// Lire la date de la dernière mise à jour
$file_path = '../json/vue-events-artists.json';
$json = file_get_contents($file_path);
$data = json_decode($json, true);
$lastUpdated = $data["vue-events"]["last-updated"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

    <div class="admin-container">
        <h1>Tableau de Bord Admin</h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="admin_artists.php">Gérer les Artistes</a></li>
                <li><a href="admin_events.php">Gérer les Événements</a></li>
                <li><a href="admin_activity_types.php">Gérer les Types d'activités</a></li>
            </ul>
        </nav>
        <div class="admin-content">
            <p>Bienvenue sur le tableau de bord d'administration. Sélectionnez une section à gérer.</p>
            <p>Dernière mise à jour : <?php echo $lastUpdated; ?></p>
            <form method="post">
                <button type="submit" name="refresh">Mettre à jour les events et artists</button>
            </form>
        </div>
    </div>

</body>
</html>