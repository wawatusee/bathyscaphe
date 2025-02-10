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

// 3️⃣ Attendre que le DOM soit chargé avant d'attacher les événements
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("artist-form");
    const saveButton = document.getElementById("save-button");
    let isModified = false;

    if (form) {
        form.addEventListener("input", function () {
            isModified = true;
            console.log("Des modifications ont été détectées !");
            if (saveButton) {
                saveButton.textContent = "Save (Modifications en cours)";
                saveButton.style.backgroundColor = "orange";
            }
        });

        window.addEventListener("beforeunload", function (event) {
            if (isModified) {
                event.preventDefault();
                event.returnValue = "Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter ?";
            }
        });

        if (saveButton) {
            saveButton.addEventListener("click", saveArtistData);
        } else {
            console.error("Le bouton Save n'a pas été trouvé !");
        }
    }
});

// 4️⃣ Fonction pour récupérer les données du formulaire en JSON
function getFormDataAsJson(form) {
    let jsonData = {};

    new FormData(form).forEach((value, key) => {
        if (key.includes("[")) {
            const parts = key.match(/([^\[]+)\[([^\]]+)\]/);
            if (parts) {
                const parentKey = parts[1];
                const childKey = parts[2];

                if (!jsonData[parentKey]) {
                    jsonData[parentKey] = {};
                }
                jsonData[parentKey][childKey] = value;
            }
        } else {
            jsonData[key] = value;
        }
    });

    return jsonData;
}

function saveArtistData() {
    console.log("Sauvegarde des données...");

    const form = document.getElementById("artist-form");
    const formData = new FormData(form);
    
    let jsonData = {
        artist: {
            id: "",
            name: "",
            illustration: "",
            art: {},
            liens: []
        }
    };

    formData.forEach((value, key) => {
        if (key.startsWith("art[")) {
            // Ex: art[en] => art.en
            let lang = key.match(/\[(.*?)\]/)[1]; // Récupère "en", "fr", "nl"
            jsonData.artist.art[lang] = value;
        } else if (key.startsWith("liens[")) {
            // Ex: liens[0][name] => récupérer "0" et "name"
            let match = key.match(/\[(\d+)\]\[(.*?)\]/);
            if (match) {
                let index = parseInt(match[1]); // Numéro de l'élément dans le tableau
                let field = match[2]; // "name" ou "link"
                
                if (!jsonData.artist.liens[index]) {
                    jsonData.artist.liens[index] = {};
                }
                jsonData.artist.liens[index][field] = value;
            }
        } else {
            // Autres champs simples
            jsonData.artist[key] = value;
        }
    });

    console.log("Données formatées :", jsonData);

    // Envoyer les données via fetch à artist-controller.php
    fetch("artist-controller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Réponse du serveur :", data);
        alert("Données sauvegardées avec succès !");
    })
    .catch(error => {
        console.error("Erreur lors de l'enregistrement :", error);
        alert("Erreur lors de la sauvegarde.");
    });
}

