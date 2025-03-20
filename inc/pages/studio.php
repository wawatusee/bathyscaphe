<?php
//DATAS studio
//Infrastructure

$studioInfrastructureContentML=[
    "fr"=>"
    <h3>Infrasctructure</h3>
    <ul>
        <li>Une régie de 12m2 et une salle d’enregistrement de 15m2</li>
        <li>Quantum HD8 - carte audio </li>
        <li>Adam A8H - enceintes de monitoring</li>
        <li>Rode NT1 - microphone</li>
        <li>Shure sm58 - microphone</li>
        <li>M-audio 88es - midi keystation</li>
        <li>Pearl export - batterie </li>
        <li>Airline Jetsons 3P – guitare </li>
        <li>Gretsch Electromatic G5420T - guitare</li>
        <li>Yamaha JX30 - amplificateur des années 70</li>
        <li>Yamaha Electone - Orgue</li>
        <li>Glockenspiel</li>
        <li>Possibilité d’enregistrer avec un piano Bösendorfer ¼ de queue de la fin du 19e siècle</li>
        <li>Cubase et Ableton Live DAW</li>
    </ul>",
    "en"=>"<h3>Infrastructure</h3>
    <ul>
        <li>Control room of 12m2 and a recording space of 15m2</li>
        <li>Quantum HD8 - audio card  </li>
        <li>Adam A8H - monitoring speakers</li>
        <li>Rode NT1 - microphone</li>
        <li>Shure sm58 - microphone</li>
        <li>M-audio 88es - midi keystation</li>
        <li>Pearl export - drum kit  </li>
        <li>Airline Jetsons 3P – guitar</li>
        <li>Gretsch Electromatic G5420T - guitar</li>
        <li>Yamaha JX30 -amplifier from the 70s</li>
        <li>Yamaha Electone - Organ</li>
        <li>Glockenspiel</li>
        <li>Possibility to record on a Bösendorfer baby grand piano from late 19th century</li>
    </ul>",
    "nl"=>"<h3>Infrastructuur</h3>
    <ul>
        <li>Controlekamer van 12m² en een opname ruimte van 15m²</li>
        <li>Quantum HD8 - audiokaart </li>
        <li>Adam A8H - monitor luidsprekers</li>
        <li>Rode NT1 - microfoon</li>
        <li>Shure sm58 - microfoon</li>
        <li>M-audio 88es - midi keystation</li>
        <li>Pearl export - drumstel </li>
        <li>Airline Jetsons 3P – gitaar </li>
        <li>Gretsch Electromatic G5420T - gitaar</li>
        <li>Yamaha JX30 -versterker uit de jaren '70</li>
        <li>Yamaha Electone - orgel</li>
        <li>Glockenspiel</li>
        <li>Mogelijkheid om op te nemen op een Bösendorfer babyvleugel uit de late 19e </li>
        <li>Cubase en Ableton Live DAW </li>
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
<!--From claude-->
<section class="studio-tools">
    <h2>Studio Equipment</h2>
    <div class="tools-grid">
        <div class="tool-card">
            <div class="tool-image">
                <img src="img/content/studio/hd8-audio-card.jpg" alt="Quantum HD8 Audio Card">
            </div>
            <div class="tool-details">
                <h3>Quantum HD8</h3>
                <p>Professional Audio Interface</p>
            </div>
        </div>
        
        <div class="tool-card">
            <div class="tool-image">
                <img src="img/content/studio/adam-a8h-speakers.jpg" alt="Adam A8H Monitoring Speakers">
            </div>
            <div class="tool-details">
                <h3>Adam A8H</h3>
                <p>High-Quality Monitoring Speakers</p>
            </div>
        </div>
        
        <!-- More tool cards... -->
    </div>
    
    <div class="studio-space">
        <h3>Studio Space</h3>
        <p>Control Room: 12m² | Recording Space: 15m²</p>
    </div>
</section>
<!--Fin from claude-->

<section class="core">
    <h2>Studio</h2>
    <article class="productenumeration">
        <?=$studioInfrastructureContentML[$lang]?>
    </article>
    <article class="productenumeration">
        <?=$studioPricingContentML[$lang]?>
    </article>
</section>