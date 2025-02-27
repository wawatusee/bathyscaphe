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
$events_view = new EventsView($list_events, $repImgEvents, $lang);
$events_html = $events_view->getEventsViewHtml($lang);

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
} else {
    $eventnumero = $eventsDatas->getDefaultEventNumero();
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
echo '<section class="core">'.$eventViewHtml.
    '</section>';
?>
<script src="js/events.js"></script>

<!--<section class="core">
    <h2>Event</h2>
    <section id="activity">
        '<article class="fullActivity">
            <div>
                <span class="infosdates" data-field="dates">Samedi 13 avril 2024<br></span>
                <span class="infosHoraires" data-field="horaire">de 18:00 à 4:00</span>
            </div>
            <h3 data-field="title">NAVIGATION #1 - ASETONE // ESTEBAN STAN // 3DB<button id="btnPartager" title="copy link and share"><img src="/public/img/deco/icons/share.png"></button></h3>
            <div class="activity-illustration"><img src="/public/img/content/bathyscaphe-in-the-air.jpg" data-field="illustration"></div>
            <div class="cardId" data-field="id">01</div>
            <div class="activity-types" data-field="types">
                <span class="card-type">exposition</span>
                <span class="card-type">Repas</span>
                <span class="card-type">concert</span>
            </div>
            <article class="activity-description">
            <div class="activity-texte">
                    <p data-field="description"> 
                    </p>
                </div>
            </article>
            <article>
                <h3>Infos pratiques</h3>
                <section class="infospratik">
                    <article class="infos-elements">
                        <span data-field="organisateur">Organisateur : <a href="https://www.bathyscaphe.be/">Bathyscaphe.be</a></span>
                        <hr>
                        <div>
                            <span class="infosdates" data-field="dates">samedi 13 avril 2024<br></span>
                            <span class="infosHoraires" data-field="horaire">de 18:00 à 4:00</span>
                        </div>
                        <hr>
                        <div class="infosresa">
                            Réservation obligatoire: <b><span data-field="booking">oui</span></b><br>
                            <span>Prix:<span data-field="price">18</span> €</span>
                        </div>
                        <hr>
                        <span class="infoslocation" data-field="location">Rue Dieudonné Lefèvre 215<br>Bruxelles<br>Belgique</span>
                    </article>
                    <div id="map2" class="infos-map-activity"></div>
                <script src="./js/share.js"></script>
                <script src="./js/mapbathy.js"></script>
                </section>
            </article>
            <br>
            <hr>
            </section>
            <article>
                <h3>Billets</h3>
                <section>
                <a href="https://www.billetweb.fr/shop.php?event=navigation-1" onclick="var w=window.open('https://www.billetweb.fr/shop.php?event=navigation-1&popup=1', 'Reserver', 'width=650, height=600, top=100, left=100, toolbar=no, resizable=yes, scrollbars=yes, status=no'); w.focus(); return false;"><img style="width:200px;" src="https://www.billetweb.fr/images/buttons/billetterie_bleu.png"></a>
                </section>
            </article>
        </article>
    </section>

</section>-->