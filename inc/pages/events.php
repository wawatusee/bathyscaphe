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

//Appel de méthode créée par Claude
$eventsSorted = $eventsDatas->sortEventsWithNextEvent();
$events_view = new EventsView($list_events, $repImgEvents);
$events_html = $events_view->getEventsViewHtml($lang, $eventsSorted);
?>

<?php
//HERE EVENTS
echo '<article class="past-events">' .
    $events_html .
    '</article> ';
?>
<!--Here EVENT-->
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
//Chargement du json Activty-types

$jsonContent = file_get_contents('../json/activity-types.json');
$activityTypesData = json_decode($jsonContent);
$activityTypes = $activityTypesData->{'art-types'};

// Chargement du json de l'event demandé
$eventJson = $eventsDatas->getJsonFullName($eventnumero);
$jsonfile = $repjsonevents . $eventJson;
$eventDatas = (new ObjetModel($jsonfile))->get_objet();

// Vue de l'événement sélectionné
require_once("../src/view/event_view.php");
$eventView = new EventView($eventDatas, $activityTypes);
$eventViewHtml = $eventView->getEventView($_GET['lang'] ?? 'fr');

// Affichage HTML
?>
<section class="core" <?= $isHidden ? 'hidden' : '' ?>>
    <button id="closeEvent">X</button>
    <?= $eventViewHtml ?>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Gestion de la fermeture de l'événement
    const eventSection = document.querySelector(".core");
    const closeButton = document.getElementById("closeEvent");

    function closeEvent() {
        eventSection.setAttribute("hidden", "");
    }

    closeButton.addEventListener("click", closeEvent);
    eventSection.addEventListener("click", function (e) {
        if (e.target === eventSection) closeEvent();
    });

    // 2. Gestion des bios d'artistes (version finale)
    function initBioCollapse() {
        document.querySelectorAll('[data-js-artist-bio]').forEach(bioElement => {
            const maxLines = 5;
            const seeMoreBtn = bioElement.nextElementSibling;
            
            // Réinitialisation pour calcul précis
            bioElement.style.maxHeight = 'unset';
            bioElement.style.webkitLineClamp = 'unset';
            
            // Calcul des dimensions
            const lineHeight = parseFloat(getComputedStyle(bioElement).lineHeight);
            const collapsedHeight = lineHeight * maxLines;
            const isOverflowing = bioElement.scrollHeight > collapsedHeight;

            // Debug
            console.log({
                element: bioElement,
                lineHeight: lineHeight,
                needsCollapse: isOverflowing,
                currentHeight: bioElement.scrollHeight
            });

            if (isOverflowing) {
                // Configuration initiale
                bioElement.classList.add('collapsed');
                bioElement.style.maxHeight = `${collapsedHeight}px`;
                bioElement.style.webkitLineClamp = maxLines;
                seeMoreBtn.style.display = 'block';
                
                // Gestion du clic
                seeMoreBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    
                    if (bioElement.classList.contains('collapsed')) {
                        // Déplier
                        bioElement.classList.remove('collapsed');
                        bioElement.style.maxHeight = `${bioElement.scrollHeight}px`;
                        setTimeout(() => {
                            bioElement.style.maxHeight = 'none';
                            bioElement.style.webkitLineClamp = 'unset';
                        }, 300);
                        seeMoreBtn.textContent = 'Voir moins';
                    } else {
                        // Replier
                        bioElement.classList.add('collapsed');
                        bioElement.style.maxHeight = `${bioElement.scrollHeight}px`;
                        setTimeout(() => {
                            bioElement.style.maxHeight = `${collapsedHeight}px`;
                            bioElement.style.webkitLineClamp = maxLines;
                        }, 10);
                        seeMoreBtn.textContent = 'Voir plus';
                    }
                });
            }
        });
    }

    // Initialisation
    initBioCollapse();
    
    // Surveillance des changements DOM
    new MutationObserver(initBioCollapse).observe(document.body, {
        subtree: true,
        childList: true
    });
});
</script>
<!-- ... Pour replier les paragraphes trop long -->
<!-- <script src="./js/biocollapsed.js"></script>-->
<!-- Pas besoin de `defer` ici, car le script est chargé en dernier -->