function generateForm(data, config, parent = document.getElementById("artist-form")) {
    parent.innerHTML = ""; // Réinitialiser le formulaire avant de le reconstruire

    for (const key in data) {
        const fieldConfig = config ? config[key] : {}; // S'assurer que config existe pour éviter une erreur
        const value = data[key];

        if (typeof value === "object" && !Array.isArray(value)) {
            // Gestion des objets (ex: 'art' avec des sous-champs 'en', 'fr', 'nl')
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${key}</legend>`;

            generateForm(value, fieldConfig, fieldset);
            parent.appendChild(fieldset);
        } else if (Array.isArray(value)) {
            // Gestion des tableaux (ex: 'liens')
            value.forEach((item, index) => {
                const fieldset = document.createElement("fieldset");
                fieldset.innerHTML = `<legend>${key} ${index + 1}</legend>`;

                if (typeof item === "object") {
                    generateForm(item, fieldConfig.structure, fieldset); // Traiter chaque objet dans le tableau
                } else {
                    // Si le tableau contient des valeurs simples
                    const input = createTextInput(`${key}[${index}]`, item);
                    fieldset.appendChild(input);
                }

                parent.appendChild(fieldset);
            });
        } else {
            // Gestion des champs simples
            const label = document.createElement("label");
            label.innerText = key.charAt(0).toUpperCase() + key.slice(1);

            let input;
            switch (key) {
                case "illustration":
                    // Afficher le nom du fichier généré pour l'illustration
                    const illustrationName = `${data.id}-${data.name}`.toLowerCase().replace(/\s+/g, '-') + ".jpg";
                    const fileNameLabel = document.createElement("label");
                    fileNameLabel.innerHTML = `<strong>Illustration:</strong> ${illustrationName}`;
                    parent.appendChild(fileNameLabel);
                    continue; // Passer à la prochaine itération
                default:
                    input = createTextInput(key, value);
                    break;
            }

            label.appendChild(input);
            parent.appendChild(label);
        }
    }
}

// Fonction pour créer un champ de texte
function createTextInput(name, value = "") {
    const input = document.createElement("input");
    input.type = "text";
    input.name = name;
    input.value = value;
    return input;
}