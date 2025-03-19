<?php
//Classes nécessaires à la présentation de l'événement
require_once("../src/model/lexique_model.php");
//Le dossier events est parsé pour en extraire les événements enregistré
$repjsonevents = "../json/events/";
$repImgEvents = $repImg . "events/";


$event20241204ContentML = [
    "en" => "texte anglais",
    "fr" => "texte français",
    "nl" => "texte néerlandais"
];
?>
<?php
require_once('../src/model/objet_model.php');
if (isset($_GET["event"])) {
    $eventnumero = $_GET["event"];
} 
//Chargement du json de l'event demandé
$eventJson = $eventsDatas->getJsonFullName($eventnumero);
$jsonfile = $repjsonevents . $eventJson;
$eventDatas = (new ObjetModel($jsonfile))->get_objet();
?>
<?php
//Vue de l'événement sélectionné
require_once("../src/view/event_view.php");
$eventView = new EventView($eventDatas);
$eventViewHtml = $eventView->getEventView($lang);
//HERE ASIDE FOR PASTS EVENTS
echo '<aside class="past-sidebar">
        <h3>Événements Passés</h3>' .
         $events_html .
        '</aside> ';
        //HERE CORE FOR FULL EVENT
echo '<section class="core">'.$eventViewHtml.'</section>';
    
?>