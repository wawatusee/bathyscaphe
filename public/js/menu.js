//Menu responsive
/*function responsiveMenu() {
    var x = document.getElementById("responsiveMenu");
    if (x.className === "responsiveMenu") {
      x.className += " responsive";
    } else {
      x.className = "responsiveMenu";
    }
  }
    function responsiveMenu() {
      const x = document.getElementById("responsiveMenu");
      x.classList.toggle("responsive"); // Ajoute ou supprime la classe "responsive"
  }*/
  function responsiveMenu() {
    const menu = document.getElementById("responsiveMenu");
    const menuIcon = document.getElementById("menuIcon");

    // Bascule la classe "responsive" pour afficher ou masquer le menu
    menu.classList.toggle("responsive");

    // Change l'icône entre ☰ et ✕
    if (menu.classList.contains("responsive")) {
        menuIcon.textContent = "✕"; /* Icône de fermeture */
    } else {
        menuIcon.textContent = "☰"; /* Icône de menu */
    }
}