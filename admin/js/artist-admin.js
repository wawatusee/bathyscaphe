function generateForm(data, config, parent = document.getElementById("artist-form"), path = "") {
    parent.innerHTML = "";

    console.log("config :", config); // Debug

    for (const key in data) {
        const value = data[key];
        const fullPath = path ? `${path}.${key}` : key;

        // Récupérer la configuration imbriquée
        const fieldConfig = getNestedConfig(config, fullPath) || {}; 
        console.log("fieldConfig pour", fullPath, ":", fieldConfig); // Debug

        if (!fieldConfig || Object.keys(fieldConfig).length === 0) {
            console.warn(`Aucune configuration trouvée pour la clé : ${fullPath}`);
        }

        if (typeof value === "object" && !Array.isArray(value)) {
            // Gestion des objets imbriqués
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            generateForm(value, config, fieldset, fullPath); // Utilisation de la config racine
            parent.appendChild(fieldset);
        } else if (Array.isArray(value)) {
            // Gestion des tableaux
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            value.forEach((item, index) => {
                const arrayPath = `${fullPath}[${index}]`;
                // Utilisez la structure spécifique pour les éléments du tableau
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
                default:
                    input = createTextInput(fullPath, value);
            }

            if (fieldConfig.required) {
                input.required = true;
            }
            
            if (fieldConfig.readonly) { // Utilisez 'readonly' en minuscules
                input.readOnly = true;
            }

            label.appendChild(input);
            parent.appendChild(label);
        }
    }
}


function createTextInput(path, value = "", readOnly = false) {
    const input = document.createElement("input");
    input.type = "text";
    input.id = path;
    input.name = path;
    input.setAttribute("data-path", path);
    input.value = value;
    if (readOnly) {
        input.readOnly = true;
    }
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
document.addEventListener("DOMContentLoaded", () => {
    const formContainer = document.getElementById("artist-form");

   if (formContainer && typeof formConfig === 'object' && typeof artistData === 'object') {
        generateForm(artistData, formConfig, formContainer);
        console.log("Config trouvée");
    } else {
        console.error("Conteneur du formulaire, configuration ou données non trouvés !");
    }
});
//DEBUG
/*function getNestedConfig(config, path) {
    if (!config || !path) return null;

    const keys = path.replace(/$$(\d+)$$/g, '.$1').split('.'); // Gère les tableaux et objets

    let currentConfig = config;

    for (const key of keys) {
        if (currentConfig[key]) {
            currentConfig = currentConfig[key];
        } else if (currentConfig && currentConfig.structure && currentConfig.structure[key]) {
            currentConfig = currentConfig.structure[key];
        } else {
            return null; // Pas de correspondance
        }
    }

    return currentConfig;
}*/
function getNestedConfig(config, path) {
    if (!config || !path) return null;

    const keys = path.replace(/\[(\d+)\]/g, '.$1').split('.'); // Correction de la RegEx

    let currentConfig = config;
    for (const key of keys) {
        if (currentConfig[key]) {
            currentConfig = currentConfig[key];
        } else if (currentConfig.structure && currentConfig.structure[key]) {
            currentConfig = currentConfig.structure[key];
        } else {
            return null;
        }
    }
    return currentConfig;
}



