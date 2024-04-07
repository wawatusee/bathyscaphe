<section class="core">
    <h2>Event</h2>
<section id="activity">
        '<article class="fullActivity">
            <h3 data-field="title">NAVIGATION #1 - ASETONE // ESTEBAN STAN // 3DB<button id="btnPartager" title="copy link and share"><img src="/public/img/deco/icons/share.png"></button></h3>
            <div class="activity-illustration"><img src="/public/img//content/bathyscaphe-in-the-air.jpg" data-field="illustration"></div>
            <span class="cardId" data-field="id">01</span>
            <div class="activity-types" data-field="types">
                <span class="card-type">exposition</span>
                <span class="card-type">Repas</span>
                <span class="card-type">concert</span>
            </div>
            <article class="activity-description">
            <div class="activity-texte">
                    <p data-field="description">All aboard, for this first Navigation edition. Music, paintings and open kitchen, for an adventure all around our senses.<br>
                        ≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈<br>
                        -Doors at 18:00<br>
                        Vernissage / Art exhibition by Asetone - "Des nuages des visages " - (Oils on canvas)<br>
                        <a href="http://www.asetone.fr/">www.asetone.fr</a><br>
                        Food with couple drinks included, catering by Frederica, suiting all diets<br>
                        ≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈<br>
                        -Opening-act at 19:30 with Esteban Stan (Blues Electro Acoustic)<br>
                        https://soundcloud.com/estebanstan<br>
                        ≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈<br>
                        -Featured-act at 21:00 with 3DB (Upbeat Bass Electronic)<br>
                        https://open.spotify.com/track/05ptFVz1VpJ8YpQe1RDZTo...<br>
                        ≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈<br>
                        -Dj set as from 22:00 with friends<br>
                        ≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈<br>
                        Bar available the whole time, bring cash<br>
                        Until late<br>
                        ≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈≈<br>
                        Tickets on presale : 18€ (link on this event page) and 20€ at the door
                    </p>
                </div>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const toggleButton = document.getElementById("toggleButton");
                    const activityTexte = document.querySelector(".activity-texte");
                    const paragraph = activityTexte.querySelector("[data-field='description']");

                    toggleButton.addEventListener("click", function() {
                        if (paragraph.style.maxHeight) {
                            paragraph.style.maxHeight = null;
                            paragraph.style.height="1em";
                            paragraph.style.overflow="hidden";
                            toggleButton.textContent = "Lire plus";
                            console.log("maxheight");
                        } else {
                            paragraph.style.maxHeight = paragraph.scrollHeight + "px";
                            toggleButton.textContent = "Lire moins";
                            console.log("none maxheight");
                        }
                    });
                });
                </script>
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
            <script>
            </script>
            <script src="./js/share.js"></script>
            <script>
             const activityLat=50.87018976225184;const activityLon=4.34392623886893;const activityTitle="Bathyscaphe.be";
            /* Création d'un carte centrée sur la latitude activityLat° N et longitude E activityLon23886893° */
    const objetCarte = L.map('map2').setView([activityLat,activityLon], 12);
        
    /* Définir le fond de carte à utiliser */
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
                {
                attribution: 'Thanks &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }
               ).addTo(objetCarte);
    /*MARKER*/ 
    /* Définition du lieu à signifier sur la carte */    
        let lieu={ "lat": activityLat, "lon": activityLon, "popup": activityTitle };
        const marqueur=L.icon({
            iconUrl: 'img/deco/icons/map-pin.svg',
            iconSize:     [38, 95], // size of the icon
            iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });
        L.marker([activityLat, activityLon], {icon: marqueur}).addTo(objetCarte).bindPopup(activityTitle);
    </script>
            </section>
        </section>
    </article>
    <br>
    <hr>
</section>
        <article>
            <h3>Billets</h3>
            <section>
            <a href="https://www.billetweb.fr/shop.php?event=navigation-1" onclick="var w=window.open('https://www.billetweb.fr/shop.php?event=navigation-1&popup=1', 'Reserver', 'width=650, height=600, top=100, left=100, toolbar=no, resizable=yes, scrollbars=yes, status=no'); w.focus(); return false;"><img style="width:200px;" src="https://www.billetweb.fr/images/buttons/billetterie_bleu.png"></a>            </section>
        </article>
    </section>
</section>