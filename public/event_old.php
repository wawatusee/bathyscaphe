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
//$events_view = new EventsView($list_events, $repImgEvents, $lang);
//$events_html = $events_view->getEventsViewHtml($lang);

$event20241204ContentML = [
    "en" => "texte anglais",
    "fr" => "texte français",
    "nl" => "texte néerlandais"
];
//Appel de méthode créée par Claude
$eventsSorted = $eventsDatas->sortEventsWithNextEvent();
var_dump($eventsSorted);
$events_view = new EventsView($list_events, $repImgEvents);
$events_html = $events_view->getEventsViewHtml($lang, $eventsSorted);
?>

<?php
//HERE EVENTS
echo '<article class="past-events">' .
    $events_html .
    '</article> ';
?>