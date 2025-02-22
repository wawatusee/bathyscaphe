<?php
// Récupérer les données POST
$activityId = $_POST['activity-id'];
$activityYear = $_POST['activity-year'];

// Charger le modèle JSON
$modelPath = '../json/activities/activity-model.json';
$modelJson = file_get_contents($modelPath);
$modelData = json_decode($modelJson, true);

// Remplir le champ "id" avec la valeur de activity-id
$modelData['id'] = $activityId;
$modelData['illustration']=$activityYear."-activity-".$activityId.".jpg";

// Créer le nom de fichier et le chemin de sauvegarde
$newFileName = $activityYear . "-activity-" . $activityId . ".json";
$saveDirectory = '../json/activities/' . $activityYear . '/';
$savePath = $saveDirectory . $newFileName;

// Vérifier si le répertoire existe, sinon le créer
if (!file_exists($saveDirectory)) {
    mkdir($saveDirectory, 0777, true);
}

// Enregistrer le nouveau fichier JSON
$results=file_put_contents($savePath, json_encode($modelData, JSON_PRETTY_PRINT));
//Debrief public et redirection
echo "<style>
    .consigne {
        background-color:hsla(10, 78%, 56%, 0.704);
        color: white;
        border: 1px solid hsla(10, 78%, 56%, 0.704);
        padding: 10px;
        width: 100%;
        font-size: 1.5em;
        box-sizing: border-box; /* Pour s'assurer que le padding est inclus dans la largeur totale */
    }
</style>";

if ($results === false) {
    $errorText="<div class='consigne'>Erreur : Impossible to write the file.</div>";
    echo $errorText;
} else {
    $successText="<div class='consigne'>Success : ". $results ."octets had been written in the file :".$newFileName."</div><div class='consigne'>You will be redirected to the activities administration page.</div>";
    header("refresh:3;url=admin.php"); // Remplace "admin-page.php" par l'URL de la page d'administration
    echo $successText;
}
// Attendre 3 secondes avant de rediriger
exit();
?>