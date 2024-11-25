function toggleAside(side) {
  // Sélectionne l'aside en fonction du côté (past ou future)
  const aside = document.querySelector(`.${side}-sidebar`);

  // Bascule la classe "show" pour afficher ou masquer l'aside
  aside.classList.toggle("show");
}

// Associer les fonctions aux boutons
document.querySelector(".time-button:not(.incoming)").addEventListener("click", function() {
  toggleAside("past-sidebar");
});

document.querySelector(".time-button.incoming").addEventListener("click", function() {
  toggleAside("future-sidebar");
});
  