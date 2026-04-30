<?php
include 'session_management.php';

$directory = "../json/events/";

// Vérifier si le dossier existe
if (!is_dir($directory)) {
    die("Erreur : Le répertoire des événements n'existe pas !");
}

// Récupérer tous les fichiers JSON qui commencent par "n" (événements)
$files = glob($directory . "n*.json");
$events = [];

// Déterminer le dernier ID utilisé
$maxId = 0;

foreach ($files as $file) {
    $filename = basename($file);

    /*if (preg_match('/^n(\d{1,3})_.*\.json$/', $filename, $matches)) {*/
    if (preg_match('/^n(\d+)\.json$/', $filename, $matches)) {
        $id = (int) $matches[1];
        // Lire le JSON
        $jsonContent = file_get_contents($file);
        $eventData = json_decode($jsonContent, true);
        $title = $eventData['event']['title'] ?? 'Titre inconnu';
        $date = $eventData['event']['time']['date'] ?? 'Date inconnue';

        $events[] = [
            "id" => $id,
            "file" => $filename,
            "title" => $title,
            "date" => $date
        ];

        if ($id > $maxId) {
            $maxId = $id;
        }
    }
}

// Prochain ID disponible
$newId = $maxId + 1;
$newIdPadded = str_pad($newId, 3, "0", STR_PAD_LEFT);

// Création d'un nouvel événement
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $today = date("Y-m-d");/*
    $defaultTitle = "Nouvel Événement";

    $sanitizedTitle = str_replace(" ", "-", $defaultTitle);
    $newFileName = "n{$newId}_{$today}_{$sanitizedTitle}.json";
    $newEventFile = $directory . $newFileName;*/
    $newFileName = "n{$newId}.json";
    $newEventFile = $directory . $newFileName;


    $newEventData = [
        "event" => [
            "id" => $newId,
            "time" => [
                "date" => date("Y-m-d"),
                "horaire" => [
                    "fr" => "",
                    "en" => "",
                    "nl" => ""
                ]
            ],
            "title" => "Nouvelévénement",
            "illustration" => "n".$newId . ".jpg",
            "activity_type_ids" => [],
            "description_event" => [
                "fr" => "",
                "en" => "",
                "nl" => ""
            ],
            "artists" => [],
            "infospratiques" => [
                "organisation" => "",
                "price" => ""
            ],

        ]
    ];

    file_put_contents($newEventFile, json_encode($newEventData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: admin_event.php?file=" . urlencode($newFileName));
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des événements</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/admin-liste-json.css">
</head>

<body>
    <header>
        <?php require_once "inc/admin_headers.php" ?>
    </header>
    <main>
        <h1>Liste des événements</h1>

        <form method="POST">
            <button type="submit" class="btn">+ Ajouter un événement</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Fichier</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars("n" . str_pad($event["id"], 3, "0", STR_PAD_LEFT)) ?></td>
                        <td><?= htmlspecialchars($event["title"]) ?></td>
                        <td><?= htmlspecialchars($event["date"]) ?></td>
                        <td><?= htmlspecialchars($event["file"]) ?></td>
                        <td>
                            <form action="upload_events_image.php" method="POST" style="display:inline;">
                                <input type="hidden" name="event_id" value="<?= htmlspecialchars($event["id"]) ?>">
                                <input type="hidden" name="event_file" value="<?= htmlspecialchars($event["file"]) ?>">
                                <button type="submit" class="btn">Img</button>
                            </form>
                        </td>
                        <td>
                            <a href="admin_event.php?file=<?= urlencode($event["file"]); ?>">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>