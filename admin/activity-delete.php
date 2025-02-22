<?php
// Récupérer l'ID de l'activité et l'année via POST
$activityId = $_POST['activity-id'];
$activityYear = $_POST['activity-year'];

// Construire le nom de fichier et le chemin d'accès
$filename = $activityYear . "-activity-" . $activityId . ".json";
$filePath = '../json/activities/' . $activityYear . '/' . $filename;
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


// Vérifier si le fichier existe
if (file_exists($filePath)) {
    // Supprimer le fichier
    if (unlink($filePath)) {
        header("refresh:3;url=admin.php");
        $successText="<div class='consigne'>The activity with the ID ".$activityId." had been deleted successfuly.</div>"."<div class='consigne'>You will be redirected to the activities administration page.</div>";
        echo $successText;
    } else {
        $errorText="<div class='consigne'>We had a situation : Impossible to delete the file.</div>";
        echo $errorText;
    }
} else {
    $missingFileText="<div class='consigne'>The activity with the ID ".$activityId." do not exist, impossible to delete something that doesn't exist.</div>";
    echo $missingFileText;
}
// Redirection après 3 secondes
exit();
?>
