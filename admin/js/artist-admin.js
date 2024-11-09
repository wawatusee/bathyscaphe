// Fonction pour générer un champ de formulaire
function createInputField(type, name, value = "") {
    const input = document.createElement("input");
    input.type = type;
    input.name = name;
    input.value = value;
    input.required = true;  // Rendre les champs requis (tu peux personnaliser ça si nécessaire)
    return input;
}

// Fonction spécifique pour gérer l'illustration
function handleIllustrationInput(artistId, artistName, input) {
    // Générer le nom de fichier à partir de l'ID de l'artiste et de son nom
    const illustrationName = `${artistId.toLowerCase()}-${artistName.toLowerCase()}.jpg`;
    return illustrationName;
}

// Modification dans la fonction generateForm() pour afficher le nom de fichier de l'illustration
function generateForm(data, config, parent = document.getElementById("artist-form")) {
    parent.innerHTML = ""; // Réinitialiser le formulaire avant de le reconstruire

    for (const key in data) {
        const fieldConfig = config ? config[key] : {};  // S'assurer que config existe pour éviter une erreur
        const value = data[key];

        const label = document.createElement("label");
        label.innerText = key.charAt(0).toUpperCase() + key.slice(1); // Mettre la première lettre en majuscule

        if (typeof value === "object" && !Array.isArray(value)) {
            // Si c'est un objet (ex: 'art' avec des sous-champs 'en', 'fr', 'nl')
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${key}</legend>`;

            generateForm(value, fieldConfig, fieldset);
            parent.appendChild(fieldset);
        } else if (Array.isArray(value) && fieldConfig.type === "array") {
            // Si c'est un tableau (ex: 'liens')
            value.forEach((item, index) => {
                const fieldset = document.createElement("fieldset");
                fieldset.innerHTML = `<legend>${key} ${index + 1}</legend>`;

                generateForm(item, fieldConfig.structure, fieldset);
                parent.appendChild(fieldset);
            });
        } else {
            // Simple champ : texte, fichier, etc.
            let input;
            switch (key) {
                case "illustration":
                    // Afficher le nom du fichier généré pour l'illustration
                    const illustrationName = `${data.id}-${data.name}`.toLowerCase().replace(/\s+/g, '-') + ".jpg"; // Exemple de nom de fichier
                    const fileNameLabel = document.createElement("label");
                    fileNameLabel.innerHTML = `<strong>Illustration:</strong> ${illustrationName}`;

                    parent.appendChild(fileNameLabel);
                    break;
                default:
                    input = createTextInput(key, value);
                    label.appendChild(input);
                    parent.appendChild(label);
                    break;
            }
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

// Fonction pour créer un champ de fichier
function createFileInput(name) {
    const input = document.createElement("input");
    input.type = "file";
    input.name = name;
    return input;
}
