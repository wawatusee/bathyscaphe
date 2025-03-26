<?php
//DATAS studio
//Infrastructure
// Inclusion des fichiers nécessaires
require_once "../src/model/lexique_model.php";
require_once '../src/view/studio_equipements_view.php';
require "../src/model/objet_model.php";
// Utilisation
// Instanciation du modèle
$repJsonEquipment = '../json/studio/studio-equipments.json';
$StudioLexiqueModel = new LexiqueModel($repJsonEquipment);
//var_dump($lexiqueModel);
$lang = $_GET['lang'] ?? 'fr';
// Instanciation de la vue en lui passant le modèle
$studioEquipmentView = new StudioEquipmentView($StudioLexiqueModel, $lang, $repImg);

$studioPricingContentML = [
    "en" => "<h2>Pricing</h2>
        <p>Music studio rental, all charges included, kitchen and bedroom for sleepovers : 200 euros per day - 1000 per week</p>
        <p>Supports available for recordings : vinyl and/or cassette, conditions to be discussed together depending on quantities</p>
        <p>Stage available for private concerts, for a first out of residency experience : up to 50 persons, with multi-camera video recording, studio-like sound recording,  in visually peculiar environment,  for future promotion</p>",
    "fr" => "<h2>Tarifs</h2>
        <p>Studio de musique, cuisine et chambre à coucher, toutes charges comprises : 200 euros par jour - 1000 euros par semaine</p>
        <p>Supports proposés pour les enregistrement: vinyle et/ou cassette, conditions à voir ensemble en fonction des quantités</p>
        <p>Plateau d’artiste disponible pour concerts privés, pour une première expérience scénique du matériel post-résidence: jusque 50 personnes, avec enregistrement vidéo multi-caméra, et captation sonore qualité studio,  dans un environnement visuellement particulier, pour toute future promotion</p>",
    "nl" => "<h2>Prijzen</h2>
        <p>Verhuur van muziekstudio, alle kosten inbegrepen, keuken en slaapkamer voor overnachtingen: 200 euro per dag - 1000 euro per week</p>
        <p>Beschikbare media voor opnames: vinyl en/of cassette, voorwaarden te bespreken afhankelijk van de hoeveelheden</p>
        <p>Podium beschikbaar voor privéconcerten, voor een eerste ervaring buiten de residentie: tot 50 personen, met multi-camera video-opname, juiste geluidsopname, in een visueel bijzondere omgeving, voor toekomstige promotie</p>"
    ];
$studioAccessContentML=[
                "en" => "<h2>Access</h2>
                    <p>Easy access from international locations. Midway between Paris, London, Amsterdam and Berlin. Zaventem Airport 30 minutes by taxi, Midi international train station 15 minutes away on Metro line 6, Pannenhuis stop</p>",
                "fr" => "<h2>Accès</h2>
                    <p>Acces facile de l'internationale. Paris, Londres, Amsterdam, Berlin pas loin. Aeroport Zaventem 20 minutes en taxi, et Gare du midi 15 minutes en metro ligne 6.</p>",
                "nl" => "<h2>Toegang</h2>
                    <p>Gemakkelijke toegang vanuit internationale locaties. Parijs, Londen, Amsterdam, Berlijn niet ver weg. Zaventem Airport 20 minuten met de taxi, en Gare du Midi 15 minuten met metrolijn 6.</p>"
                    ]
    ?>

<section class="core">
    <h2>Studio</h2>
    <article class="productenumeration">
        <?= $studioEquipmentView->render(); ?>
    </article>
    <article class="simpleArticle">
        <?= $studioPricingContentML[$lang] ?>
    </article>
    <article class="simpleArticle">
        <?=$studioAccessContentML[$lang]?>
    </article>
</section>