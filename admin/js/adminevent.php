<?php
//Classes nécessaires à la présentation des événements
require_once("../src/model/events_model.php");
require_once("../src/view/events_view.php");
require_once("../src/model/lexique_model.php");
//Le dossier events est parsé pour en extraire les événements enregistré
$repjsonevents="../json/events/";
$eventsDatas=new EventsModel($repjsonevents);
$list_events=$eventsDatas->getFichiers();
//Création et présentation de l'html généré à partir de la liste des événements
$repImgEvents=$repImg."events/";
$events_view = new EventsView($list_events, $repImgEvents,$lang);
$events_html = $events_view->getEventsViewHtml($lang);
echo $events_html;
$event20241204ContentML=[
    "en"=>"texte anglais",
    "fr"=>"texte français",
    "nl"=>"texte néerlandais"
]
?>
<?php
 if (isset($_GET["event"])){
    require_once('../src/model/objet_model.php' );
   $eventnumero=$_GET["event"];
   //Chargement du json de l'event demandé
   $eventJson=$eventsDatas->getJsonFullName($eventnumero);
    $jsonfile=$repjsonevents.$eventJson;
    $eventDatas=(new ObjetModel($jsonfile))->get_objet();
}
?>
<?php
//Vue de l'événement sélectionné
require_once("../src/view/event_view.php");
$eventView=new EventView($eventDatas);
$eventViewHtml=$eventView->getEventView($lang);
echo $eventViewHtml;
?>
