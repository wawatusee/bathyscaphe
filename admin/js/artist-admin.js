/*function generateForm(data, config, parent = document.getElementById("artist-form"), path = "") {
    parent.innerHTML = ""; // Réinitialiser le formulaire avant de le reconstruire

    for (const key in data) {
        const fieldConfig = config ? config[key] : {}; // S'assurer que config existe pour éviter une erreur
        const value = data[key];
        const fullPath = path ? `${path}.${key}` : key; // Chemin hiérarchique du champ

        if (typeof value === "object" && !Array.isArray(value)) {
            // Gestion des objets (ex: 'art' avec des sous-champs 'en', 'fr', 'nl')
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${key}</legend>`;
            generateForm(value, fieldConfig, fieldset, fullPath);
            parent.appendChild(fieldset);
        } else if (Array.isArray(value)) {
            // Gestion des tableaux
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${key}</legend>`;
            parent.appendChild(fieldset);

            value.forEach((item, index) => {
                const arrayPath = `${fullPath}[${index}]`;
                const itemFieldset = document.createElement("fieldset");
                itemFieldset.innerHTML = `<legend> ${key} ${index + 1}</legend>`;

                if (typeof item === "object") {
                    generateForm(item, fieldConfig.structure, itemFieldset, arrayPath);
                } else {
                    const input = createTextInput(arrayPath, item);
                    itemFieldset.appendChild(input);
                }

                // Bouton de suppression pour chaque élément du tableau
                const removeButton = document.createElement("button");
                removeButton.innerText = "Supprimer";
                removeButton.type = "button";
                removeButton.onclick = () => {
                    fieldset.removeChild(itemFieldset);
                };

                itemFieldset.appendChild(removeButton);
                fieldset.appendChild(itemFieldset);
            });

            // Ajouter un bouton pour insérer un nouvel élément dans le tableau
            const addButton = document.createElement("button");
            addButton.innerText = `Ajouter ${key}`;
            addButton.type = "button";
            addButton.onclick = () => {
                const newIndex = fieldset.children.length - 1; // Compter les éléments existants
                const newFieldset = document.createElement("fieldset");
                newFieldset.innerHTML = `<legend>${key} ${newIndex + 1}</legend>`;

                if (key === "liens") {
                    const nameInput = createTextInput(`${fullPath}[${newIndex}].name`, "");
                    const linkInput = createTextInput(`${fullPath}[${newIndex}].link`, "");
                    newFieldset.appendChild(nameInput);
                    newFieldset.appendChild(linkInput);
                }

                // Bouton de suppression pour le nouvel élément
                const removeButton = document.createElement("button");
                removeButton.innerText = "Supprimer";
                removeButton.type = "button";
                removeButton.onclick = () => {
                    fieldset.removeChild(newFieldset);
                };

                newFieldset.appendChild(removeButton);
                fieldset.appendChild(newFieldset);
            };

            parent.appendChild(addButton);
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
                    input = createTextInput(fullPath, value);
                    break;
            }

            label.appendChild(input);
            parent.appendChild(label);
        }
    }
}*/
function generateForm(data, config, parent = document.getElementById("artist-form"), path = "") {
    parent.innerHTML = "";

    console.log("config :", config); // Debug

    for (const key in data) {
        const fieldConfig = config ? config[key] : {}; // Récupérer la configuration du champ
        console.log("fieldConfig pour", key, ":", fieldConfig); // Debug

        const value = data[key];
        const fullPath = path ? `${path}.${key}` : key;

        if (typeof value === "object" && !Array.isArray(value)) {
            // Gestion des objets imbriqués
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            generateForm(value, fieldConfig.structure, fieldset, fullPath);
            parent.appendChild(fieldset);
        } else if (Array.isArray(value)) {
            // Gestion des tableaux
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            value.forEach((item, index) => {
                const arrayPath = `${fullPath}[${index}]`;
                generateForm(item, fieldConfig.structure, fieldset, arrayPath);
            });
            parent.appendChild(fieldset);
        } else {
            // Gestion des champs simples
            const label = document.createElement("label");
            label.innerText = fieldConfig.label || key.charAt(0).toUpperCase() + key.slice(1);

            let input;
            switch (fieldConfig.type) {
                case "text":
                    input = createTextInput(fullPath, value);
                    break;
                case "date":
                    input = createDateInput(fullPath, value);
                    break;
                case "file":
                    input = createFileInput(fullPath, value, fieldConfig.accept);
                    break;
                default:
                    input = createTextInput(fullPath, value);
            }

            if (fieldConfig.required) {
                input.required = true;
            }

            if (fieldConfig.readonly) {
                input.readOnly = true; // Utiliser readOnly (avec un O majuscule)
            }

            label.appendChild(input);
            parent.appendChild(label);
        }
    }
}

function createTextInput(path, value = "") {
    const input = document.createElement("input");
    input.type = "text";
    input.id = path; // Ajouter un attribut id
    input.name = path;
    input.setAttribute("data-path", path);
    input.value = value;
    return input;
}

function setJsonValue(obj, path, value) {
    const keys = path.split("."); // Séparer par points
    let current = obj;

    for (let i = 0; i < keys.length - 1; i++) {
        let key = keys[i];

        if (key.includes("[")) {
            let [arrayKey, index] = key.match(/(.*?)\[(\d+)\]/).slice(1);
            index = parseInt(index);

            if (!current[arrayKey]) {
                current[arrayKey] = [];
            }
            if (!current[arrayKey][index]) {
                current[arrayKey][index] = {};
            }
            current = current[arrayKey][index];
        } else {
            if (!current[key]) {
                current[key] = {};
            }
            current = current[key];
        }
    }

    current[keys[keys.length - 1]] = value;
}

let saveButton; // Déclarer saveButton comme variable globale

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("artist-form");
    saveButton = document.getElementById("save-button"); // Initialiser saveButton ici

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
    const inputs = form.querySelectorAll("input[data-path]");

    let jsonData = {};

    inputs.forEach(input => {
        const path = input.getAttribute("data-path");
        const value = input.value;
        setJsonValue(jsonData, path, value);
    });

    console.log("Données formatées :", jsonData);

    fetch("artist-controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(jsonData)
    })
        .then(response => response.json())
        .then(data => {
            console.log("Réponse du serveur :", data);

            if (data.success) {
                alert("Données sauvegardées avec succès !");
                isModified = false;
                saveButton.textContent = "Save"; // Utiliser saveButton ici
                saveButton.style.backgroundColor = "";
            } else {
                alert("Erreur lors de la sauvegarde : " + data.message);
            }
        })
        .catch(error => {
            console.error("Erreur lors de l'enregistrement :", error);
            alert("Erreur lors de la sauvegarde.");
        });
}
document.addEventListener("DOMContentLoaded", function () {
    const formContainer = document.getElementById("artist-form");

    if (formContainer && formConfig && artistData) {
        generateForm(artistData, formConfig.artist, formContainer); // Générer le formulaire
        console.log("Config trouvée");
    } else {
        console.error("Conteneur du formulaire, configuration ou données non trouvés !");
    }
});
