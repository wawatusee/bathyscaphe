const map = L.map('map').setView([50.85045, 4.34878], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
const events_array=a_tour[1].activities;
const refs_array=a_tour[0].refs;
const types_array=refs_array.types;
const langueDeLaPage = document.documentElement.lang;
for (chaqueEvent in events_array){
  let fullPageLink=`<a href="activity.php?activityId=${events_array[chaqueEvent].id}&lang=${langueDeLaPage}">Link : ${events_array[chaqueEvent].title}</a>`;
  let marker=L.marker([events_array[chaqueEvent].location.coordonates.lat,events_array[chaqueEvent].location.coordonates.lon]).addTo(map);
  marker.bindPopup(`${events_array[chaqueEvent].title}-${events_array[chaqueEvent].id}<br>${fullPageLink}`);
}
//Carte d'activité
var map2 = L.map('map2').setView([50.85045, 4.34878], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map2);
// Ajouter un marqueur aux coordonnées après chargement de la page
document.addEventListener("DOMContentLoaded", function() {
  // Attendre que le DOM soit complètement chargé

  // Récupérer les coordonnées de latitude et de longitude depuis vos constantes
  const latitude = activityLat;
  const longitude = activityLon;
  const titreActivity=activityTitle;

  // Créer un marqueur et ajoutez-le à votre carte map2
  const marker = L.marker([latitude, longitude]).addTo(map2);

  //Ajouter une popup au marqueur
  marker.bindPopup(titreActivity).openPopup();
});


