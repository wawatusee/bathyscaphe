<?php
//Classes nécessaires à la présentation des événements
require_once("../src/utils/file_manager.php");
require_once("../src/model/events_model.php");
require_once("../src/view/events_view.php");
require_once("../src/model/lexique_model.php");
//Le dossier events est parsé pour en extraire les événements enregistré
$repjsonevents = "../json/events/";
$eventsDatas = new EventsModel($repjsonevents);
$list_events = $eventsDatas->getFichiers();
//Création et présentation de l'html généré à partir de la liste des événements
$repImgEvents = $repImg . "events/";

$event20241204ContentML = [
    "en" => "texte anglais",
    "fr" => "texte français",
    "nl" => "texte néerlandais"
];
//Appel de méthode créée par Claude
$eventsSorted = $eventsDatas->sortEventsWithNextEvent();
//var_dump($eventsSorted);
$events_view = new EventsView($list_events, $repImgEvents);
$events_html = $events_view->getEventsViewHtml($lang, $eventsSorted);
?>

<?php
//HERE EVENTS
echo '<article class="past-events">' .
    $events_html .
    '</article> ';
?>
<?php
//Here EVENT
/*require_once('../src/model/objet_model.php');
if (isset($_GET["event"])) {
    $eventHidden='';
    $eventnumero = $_GET["event"];
} else {
    $eventnumero = $eventsDatas->getDefaultEventNumero();
    $eventHidden='hidden';
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

        //HERE CORE FOR FULL EVENT
echo '<section class="core"'. $eventHidden.'>'.$eventViewHtml.'</section>';
*/?>
<?php
require_once('../src/model/objet_model.php');

// Vérification stricte du format "n" + chiffre(s)
if (isset($_GET['event']) && preg_match('/^n\d+$/i', $_GET['event'])) {
    $eventnumero = $_GET['event'];
    $isHidden = false;
} else {
    $eventnumero = $eventsDatas->getDefaultEventNumero();
    $isHidden = true;
}

// Chargement du json de l'event demandé
$eventJson = $eventsDatas->getJsonFullName($eventnumero);
$jsonfile = $repjsonevents . $eventJson;
$eventDatas = (new ObjetModel($jsonfile))->get_objet();

// Vue de l'événement sélectionné
require_once("../src/view/event_view.php");
$eventView = new EventView($eventDatas);
$eventViewHtml = $eventView->getEventView($_GET['lang'] ?? 'fr');

// Affichage HTML
?>
<section class="core" <?= $isHidden ? 'hidden' : '' ?>><?= $eventViewHtml ?></section>

<script src="js/events.js"></script>