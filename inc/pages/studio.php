<?php
//DATAS studio
//Infrastructure

$studioInfrastructureContentML=[
    "fr"=>"
    <h3>Infrasctructure</h3>
    <ul>
        <li>Studio de musique</li>
        <li>2 pièces</li>
        <li>une régie de 12m2</li>
        <li>et un espace d’enregistrement de 15m2</li>
        <li>Batterie Pearl Export avec micros batterie</li>
        <li>Piano Quart de Queue Bösendorfer</li>
        <li>Synthétiseur</li>
        <li>Micros</li>
        <li>Préamplificateur</li>
        <li>Carte son</li>
        <li>logiciel DAW: Protools et Ableton Live11</li>
    </ul>",
    "en"=>"<h3>Infrastructure</h3>
    <ul>
        <li>Music studio</li>
        <li>2 rooms</li>
        <li>A control room of 12m2</li>
        <li>and a recording space of 15m2</li>
        <li>Pearl Export drum kit with drum microphones</li>
        <li>Bösendorfer Grand Piano</li>
        <li>Synthesizer</li>
        <li>Microphones</li>
        <li>Preamp</li>
        <li>Sound card</li>
        <li>DAW software: Protools and Ableton Live11</li>
    </ul>",
    "nl"=>"<h3>Infrastructuur</h3>
    <ul>
        <li>Muziekstudio</li>
        <li>2 kamers</li>
        <li>Een controlekamer van 12m2</li>
        <li>en een opnameruimte van 15m2</li>
        <li>Pearl Export drumstel met drummicrofoons</li>
        <li>Bösendorfer vleugelpiano</li>
        <li>Synthesizer</li>
        <li>Microfoons</li>
        <li>Voorversterker</li>
        <li>Geluidskaart</li>
        <li>DAW-software: Protools en Ableton Live11</li>
    </ul>"
];
$studioPricingContentML=[
    "en"=>"<h3>Pricing</h3>
    <ul>
        <li>Entire location rental for shoots: films, clips, interviews, etc... (250 euros per day, 1500 euros per week)</li>
        <li>Music studio rental, including sound engineer, all charges included, kitchen available, bedroom on site for two people available (350 euros per day, or package deal 2500 per week).</li>
        <li> Vinyl possible as a bonus and artist stage available for first concert of residence, about 50 people.</li>
    </ul><br>
    <p>Easy access from international locations. Paris, London, Amsterdam, Berlin not far away. Zaventem Airport 20 minutes by taxi, and Gare du Midi 15 minutes by metro line 6.</p>",
    "fr"=>"<h3>Tarifs</h3>
    <ul>
        <li>Location lieu entier pour tournages: films, clips, interviews, etc... (250 euros la journee, 1500 euros la semaine)</li>
        <li>Location studio de musique, ingenieur du son compris, toutes charges comprises, cuisine disponible, chambre a coucher sur place pour deux personnes disponible (350 euros a la journee, ou forfait embarque 2500 la semaine).</li>
        <li>Vinyl possible à la clef et plateau d'artiste disponible pour premier concert concert de sortie de residence, environ 50 personnes.</li>
    </ul><br>
    <p>Acces facile de l'internationale. Paris, Londres, Amsterdam, Berlin pas loin. Aeroport Zaventem 20 minutes en taxi, et Gare du midi 15 minutes en metro ligne 6.</p>",
    "nl"=>"<h3>Prijzen</h3>
    <ul>
        <li>Volledige locatieverhuur voor opnames: films, clips, interviews, enz... (250 euro per dag, 1500 euro per week)</li>
        <li>Verhuur van muziekstudio, inclusief geluidstechnicus, alle kosten inbegrepen, keuken beschikbaar, slaapkamer ter plaatse voor twee personen beschikbaar (350 euro per dag, of pakketdeal 2500 per week).</li>
        <li>Vinyl mogelijk als extra en podium beschikbaar voor het eerste concert van de residentie, ongeveer 50 personen.</li>
    </ul><br>
    <p>Gemakkelijke toegang vanuit internationale locaties. Parijs, Londen, Amsterdam, Berlijn niet ver weg. Zaventem Airport 20 minuten met de taxi, en Gare du Midi 15 minuten met metrolijn 6.</p>"
]
?>
<section class="core">
    <h2>Studio</h2>
    <article class="productenumeration">
        <?=$studioInfrastructureContentML[$lang]?>
    </article>
    <article class="productenumeration">
        <?=$studioPricingContentML[$lang]?>
    </article>
</section>