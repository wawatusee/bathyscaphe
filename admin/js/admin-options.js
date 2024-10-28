// Sélectionner tous les éléments avec la classe 'event-card'
const eventCards = document.querySelectorAll(".event-card");

eventCards.forEach((card) => {
  const cardIdSpan = card.querySelector(".cardId");
  const cardId = cardIdSpan ? cardIdSpan.textContent.trim() : "ID inconnu";

  const linkContainer = document.createElement("div");
  linkContainer.className = "event-options";

  const title = document.createElement("h3");
  title.textContent = `event ${cardId} options`;

  const imgLink = document.createElement("a");
  imgLink.textContent = "Add img";
  imgLink.href = `activity-img.php?id=${cardId}`;
  imgLink.className = "img-link";

  const suppLink = document.createElement("a");
  suppLink.textContent = "Delete";
  suppLink.href = "#";
  suppLink.className = "supp-link";
  suppLink.addEventListener("click", function (event) {
    event.preventDefault();
    // Création du formulaire
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "activity-delete.php"; // URL de suppression

    // Création du champ caché pour l'ID de l'activité
    const idInput = document.createElement("input");
    idInput.type = "hidden";
    idInput.name = "activity-id";
    idInput.value = cardId;
    form.appendChild(idInput);

    // Création du champ caché pour l'année (si nécessaire)
    const yearInput = document.createElement("input");
    yearInput.type = "hidden";
    yearInput.name = "activity-year";
    yearInput.value = "2024"; // Remplace par la bonne valeur si nécessaire
    form.appendChild(yearInput);

    // Ajout du formulaire à la page
    document.body.appendChild(form);

    // Soumission du formulaire
    form.submit();
  });

  linkContainer.appendChild(title);
  linkContainer.appendChild(imgLink);
  linkContainer.appendChild(suppLink);

  card.insertAdjacentElement("afterend", linkContainer);
});
