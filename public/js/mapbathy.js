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
          