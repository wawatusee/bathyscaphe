function generateEventForm(data, parent = document.getElementById("event-form"), path = "") {
    const config = window.formConfig;
    console.log(parent);
    // Vérification de l'existence et validité de 'parent'
    if (!(parent instanceof HTMLElement)) {
        console.error("L'élément parent n'est pas valides", parent);
        return;
    }

    // Vérification de la config
    if (!config || !config.event) {
        console.error("Configuration de l'événement introuvable !");
        return;
    }

    parent.innerHTML = ""; // Réinitialise le contenu du formulaire
    for (const key in data) {
        const value = data[key];
        const fullPath = path ? `${path}.${key}` : key;
        const fieldConfig = config.event[key] || {};  // Assure-toi que la clé existe dans config

        console.log(`Clé: ${key}, Configuration:`, fieldConfig);

        // Si c'est un objet, et qu'il y a une sous-structure (par exemple "description")
        if (typeof value === "object" && !Array.isArray(value)) {
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;

            // Si un champ "structure" existe, il faut générer les champs pour chaque sous-clé
            if (fieldConfig.structure) {
                for (const subKey in fieldConfig.structure) {
                    const subFieldConfig = fieldConfig.structure[subKey];
                    const subValue = value[subKey]; // Récupère la valeur pour la langue spécifique
                    const subFieldPath = `${fullPath}.${subKey}`;
                    const subLabel = subFieldConfig.label || subKey;

                    // Génère un champ pour chaque sous-clé (ex. description.fr, description.en, description.nl)
                    const subLabelElement = document.createElement("label");
                    subLabelElement.innerText = subLabel;

                    let subInput;
                    switch (subFieldConfig.type) {
                        case "text":
                            subInput = createTextInput(subFieldPath, subValue);
                            break;
                        // Gérer d'autres types si nécessaire (par exemple, date)
                        default:
                            subInput = createTextInput(subFieldPath, subValue);
                    }

                    if (subFieldConfig.required) {
                        subInput.required = true;
                    }

                    subLabelElement.appendChild(subInput);
                    fieldset.appendChild(subLabelElement);
                }
            } else {
                generateEventForm(value, fieldset, fullPath); // Appel récursif pour objets sans sous-structure
            }

            parent.appendChild(fieldset);
        } else if (Array.isArray(value)) {
            // Logique pour gérer les tableaux, si nécessaire
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            value.forEach((item, index) => {
                const entryWrapper = document.createElement("fieldset");
                generateEventForm(item, entryWrapper, `${fullPath}[${index}]`);
                fieldset.appendChild(entryWrapper);
            });
            parent.appendChild(fieldset);
        } else {
            // Logique pour les champs simples
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

            label.appendChild(input);
            parent.appendChild(label);
        }
    }
}



function createTextInput(path, value = "") {
    const input = document.createElement("input");
    input.type = "text";
    input.id = path;
    input.name = path;
    input.setAttribute("data-path", path);
    input.value = value;
    return input;
}

function createDateInput(path, value = "") {
    const input = document.createElement("input");
    input.type = "date";
    input.id = path;
    input.name = path;
    input.setAttribute("data-path", path);
    input.value = value;
    return input;
}

function setJsonValue(obj, path, value) {
    const keys = path.split(".");
    let current = obj;

    for (let i = 0; i < keys.length - 1; i++) {
        let key = keys[i];
        if (key.includes("[")) {
            let [arrayKey, index] = key.match(/(.*?)\[(\d+)\]/).slice(1);
            index = parseInt(index);
            if (!current[arrayKey]) current[arrayKey] = [];
            if (!current[arrayKey][index]) current[arrayKey][index] = {};
            current = current[arrayKey][index];
        } else {
            if (!current[key]) current[key] = {};
            current = current[key];
        }
    }

    current[keys[keys.length - 1]] = value;
}

function getNestedConfig(config, path) {
    const parts = path.replace(/\[(\d+)]/g, '.$1').split('.');
    let fieldConfig = config;

    for (let part of parts) {
        if (!fieldConfig) return undefined;
        if (Array.isArray(fieldConfig)) {
            fieldConfig = fieldConfig[part];
        } else if (typeof fieldConfig === 'object' && part in fieldConfig) {
            fieldConfig = fieldConfig[part];
        } else {
            return undefined;
        }
    }

    return fieldConfig;
}

function saveEventData() {
    const form = document.getElementById("event-form");
    const inputs = form.querySelectorAll("input[data-path]");
    let jsonData = {};

    inputs.forEach(input => {
        const path = input.getAttribute("data-path");
        const value = input.value;
        setJsonValue(jsonData, path, value);
    });

    // Nettoyage éventuel ici si nécessaire
    console.log("Données à envoyer :", jsonData);

    fetch("event-controller.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Événement sauvegardé !");
            isModified = false;
            saveButton.textContent = "Save";
            saveButton.style.backgroundColor = "";
        } else {
            alert("Erreur : " + data.message);
        }
    })
    .catch(error => {
        console.error("Erreur lors de l'enregistrement :", error);
        alert("Erreur réseau.");
    });
}

let isModified = false;
let saveButton;

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("event-form");
    const saveButton = document.getElementById("save-button");

    console.log("form:", form);  // Vérification de l'élément form

    if (form && typeof formConfig === 'object' && typeof eventData === 'object') {
        // Vérification de l'existence de l'élément parent
        if (form instanceof HTMLElement) {
            console.log("formConfigEvent dans generateEventForm:", formConfig.event);
            generateEventForm(eventData.event, form, formConfig.event);

            console.log("Formulaire événement généré.");
        } else {
            console.error("L'élément parent n'est pas valide.");
        }
    } else {
        console.error("Impossible de générer le formulaire : données manquantes.");
    }

    if (form) {
        form.addEventListener("input", () => {
            isModified = true;
            if (saveButton) {
                saveButton.textContent = "Save (Modifié)";
                saveButton.style.backgroundColor = "orange";
            }
        });
    }

    if (saveButton) {
        saveButton.addEventListener("click", saveEventData);
    }

    window.addEventListener("beforeunload", function (event) {
        if (isModified) {
            event.preventDefault();
            event.returnValue = "Modifications non sauvegardées. Quitter ?";
        }
    });
});
