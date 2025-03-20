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
$eventJson = 'n1_2024-04-13_asetone_esteban-stan_3DB.json';
$jsonfile = $repjsonevents . $eventJson;
$eventDatas = (new ObjetModel($jsonfile))->get_objet();
?>
<?php
//Vue de l'événement sélectionné
require_once("../src/view/event_view.php");
$eventView = new EventView($eventDatas);
$eventViewHtml = $eventView->getEventView($lang);

        //HERE CORE FOR FULL EVENT
echo '<section class="core">'.$eventViewHtml.'</section>';
?>
<?php
//Claude code
require_once('../src/model/events_model.php');
require_once('../src/model/objet_model.php');
require_once('../src/view/event_view.php');

// Répertoire des événements JSON
$repjsonevents = "../json/events/";

// Instancier le modèle des événements
$eventsDatas = new EventsModel($repjsonevents);

// Déterminer l'événement à afficher
if (isset($_GET["event"])) {
    $eventnumero = $_GET["event"];
} else {
    $eventnumero = $eventsDatas->get_default_event_numero();
}

// Charger le JSON de l'événement
$eventJson = $eventsDatas->getJsonFullName($eventnumero);
$jsonfile = $repjsonevents . $eventJson;

// Créer l'objet de l'événement
$eventDatas = (new ObjetModel($jsonfile))->get_objet();

// Créer et afficher la vue de l'événement
$eventView = new EventView($eventDatas);
$eventViewHtml = $eventView->getEventView($lang);

echo $eventViewHtml;
?>