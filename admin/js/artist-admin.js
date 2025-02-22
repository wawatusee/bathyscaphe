function generateForm(data, config, parent = document.getElementById("artist-form"), path = "") {
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
        }else {
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
}

// Fonction pour créer un champ de texte avec data-path
function createTextInput(path, value = "") {
    const input = document.createElement("input");
    input.type = "text";
    input.name = path;
    input.setAttribute("data-path", path); // Stocker le chemin hiérarchique
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

/*function saveArtistData() {
    console.log("Sauvegarde des données...");

    const form = document.getElementById("artist-form");
    const inputs = form.querySelectorAll("input[data-path]");

    let jsonData = {}; // Suppression de `{ artist: {} }`

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
        alert("Données sauvegardées avec succès !");
    })
    .catch(error => {
        console.error("Erreur lors de l'enregistrement :", error);
        alert("Erreur lors de la sauvegarde.");
    });
}*/
function saveArtistData() {
    console.log("Sauvegarde des données...");

    const form = document.getElementById("artist-form");
    const inputs = form.querySelectorAll("input[data-path]");

    // Initialiser jsonData avec le nom du fichier
    let jsonData = { file: db_json.artist.file, artist: {} };

    inputs.forEach(input => {
        const path = input.getAttribute("data-path");
        const value = input.value;

        setJsonValue(jsonData.artist, path, value);
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
            saveButton.textContent = "Save";
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