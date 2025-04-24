/* function generateEventForm(data, parent = document.getElementById("event-form"), path = "") {
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
        if (fieldConfig.type === "checkboxes" && fieldConfig.structure && fieldConfig.source) {
            // ✅ Cas spécial : checkboxes dynamiques
            const label = document.createElement("label");
            label.innerText = fieldConfig.label || key;

            const checkboxGroup = createCheckboxGroup(fieldConfig, value, fullPath);
            label.appendChild(checkboxGroup);
            parent.appendChild(label);

        } else if (typeof value === "object" && !Array.isArray(value)) {
            // 🌐 Cas général : objet avec sous-clés ou structure
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;

            if (fieldConfig.structure && typeof fieldConfig.structure === "object") {
                for (const subKey in fieldConfig.structure) {
                    const subValue = value[subKey];
                    const subFieldPath = `${fullPath}.${subKey}`;
                    const subLabel = subKey;

                    const subLabelElement = document.createElement("label");
                    subLabelElement.innerText = subLabel;

                    const subInput = createTextInput(subFieldPath, subValue);
                    subLabelElement.appendChild(subInput);
                    fieldset.appendChild(subLabelElement);
                }
            } else {
                generateEventForm(value, fieldset, fullPath); // Appel récursif
            }

            parent.appendChild(fieldset);
        }
        else if (Array.isArray(value)) {
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
*/
function createTextInput(path, value = "") {
    const input = document.createElement("input");
    input.type = "text";
    input.id = path;
    input.name = path;
    input.setAttribute("data-path", path);
    input.value = value;
    return input;
} 
function generateEventForm(data, parent = document.getElementById("event-form"), path = "") {
    const config = window.formConfig;

    if (!(parent instanceof HTMLElement)) {
        console.error("L'élément parent n'est pas valide", parent);
        return;
    }

    if (!config || !config.event) {
        console.error("Configuration de l'événement introuvable !");
        return;
    }

    parent.innerHTML = ""; // Réinitialise le contenu

    for (const key in data) {
        const value = data[key];
        const fullPath = path ? `${path}.${key}` : key;
        const fieldConfig = config.event[key] || {};

        // 🔹 Cas spécial : checkboxes au premier niveau
        if (fieldConfig.type === "checkboxes" && fieldConfig.structure && fieldConfig.source) {
            const label = document.createElement("label");
            label.innerText = fieldConfig.label || key;

            const checkboxGroup = createCheckboxGroup(fieldConfig, value, fullPath);
            
            label.appendChild(checkboxGroup);
            parent.appendChild(label);

        } else if (typeof value === "object" && !Array.isArray(value)) {
            // 🔹 Cas objet avec sous-champs
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;

            if (fieldConfig.structure && typeof fieldConfig.structure === "object") {
                for (const subKey in fieldConfig.structure) {
                    const subValue = value[subKey];
                    const subFieldConfig = fieldConfig.structure[subKey];
                    const subFieldPath = `${fullPath}.${subKey}`;
                    const subLabel = subFieldConfig.label || subKey;

                    const subLabelElement = document.createElement("label");
                    subLabelElement.innerText = subLabel;

                    let subInput;

                    switch (subFieldConfig.type) {
                        case "text":
                            subInput = createTextInput(subFieldPath, subValue);
                            break;
                            case "checkbox":
                                subInput = document.createElement("input");
                                subInput.type = "checkbox";
                                subInput.id = subFieldPath;
                                subInput.name = subFieldPath;
                                subInput.setAttribute("data-path", subFieldPath);
                                subInput.checked = !!subValue;
                                break;
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
                generateEventForm(value, fieldset, fullPath); // Appel récursif
            }

            parent.appendChild(fieldset);

        } else if (Array.isArray(value)) {
            // 🔹 Cas tableau
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;

            value.forEach((item, index) => {
                const entryWrapper = document.createElement("fieldset");
                generateEventForm(item, entryWrapper, `${fullPath}[${index}]`);
                fieldset.appendChild(entryWrapper);
            });

            parent.appendChild(fieldset);

        } else {
            // 🔹 Cas champ simple
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

function createCheckboxGroup(config, selectedValues = [], path) {
    const wrapper = document.createElement("div");
    wrapper.classList.add("checkbox-group");
    fetch(config.source)
        .then(res => res.json())
        .then(dataList => {
            // Si le JSON a une clé racine (ex: "art-types"), on la prend
            if (Array.isArray(dataList)) {
                // rien à faire
            } else if (dataList["art-types"]) {
                dataList = dataList["art-types"];
            }
            dataList.forEach(item => {
                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = path;
                checkbox.value = item[config.structure.id];
                checkbox.checked = selectedValues.includes(item[config.structure.id]);
                checkbox.setAttribute("data-path", path);

                const label = document.createElement("label");
                label.textContent = item[config.structure.label];
                label.prepend(checkbox);

                wrapper.appendChild(label);
            });
        })
        .catch(err => {
            console.error("Erreur de chargement (checkboxes):", err);
            wrapper.innerHTML = "<p>Impossible de charger les données.</p>";
        });

    return wrapper;
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
    console.log("Path:", path, "Value:", value); // Log pour chaque appel
    const keys = path.split('.');
    let current = obj;

    for (let i = 0; i < keys.length - 1; i++) {
        let key = keys[i];
        console.log("Current Key:", key); // Log pour chaque clé
        if (key.includes("[")) {
            let match = key.match(/(.*?)$$(\d+)$$/);
            if (match) {
                let [arrayKey, index] = match.slice(1);
                index = parseInt(index);
                if (!current[arrayKey]) current[arrayKey] = [];
                if (!current[arrayKey][index]) current[arrayKey][index] = {};
                current = current[arrayKey][index];
            } else {
                // Si key ne correspond pas au format attendu, traiter key comme une clé simple
                if (!current[key]) current[key] = {};
                current = current[key];
            }
        } else {
            if (!current[key]) current[key] = {};
            current = current[key];
        }
        console.log("Current Object:", current); // Log pour voir l'état de l'objet
    }

    // Dernière clé
    let lastKey = keys[keys.length - 1];
    // Gestion des tableaux pour la dernière clé
    if (lastKey.includes('[')) {
        let match = lastKey.match(/(.*?)$$(\d+)$$/);
        if (match) {
            let [arrayKey, index] = match.slice(1);
            index = parseInt(index);
            if (!current[arrayKey]) current[arrayKey] = [];
            current[arrayKey][index] = value;
        } else {
            current[lastKey] = value;
        }
    } else {
        current[lastKey] = value;
    }
    console.log("Final Object:", obj); // Log final pour voir l'état complet de l'objet
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
/* function saveEventData() {
    const form = document.getElementById("event-form");
    const inputs = form.querySelectorAll("input[data-path], input[type='checkbox']");
    let jsonData = { event: {} }; // Initialiser correctement la structure

    inputs.forEach(input => {
        const path = input.getAttribute("data-path");
        let value = input.type === 'checkbox' ? input.checked : input.value;

        // Conversion des valeurs booléennes
        if (value === 'true') value = true;
        if (value === 'false') value = false;

        setJsonValue(jsonData.event, path, value); // Utiliser jsonData.event ici
    });

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
                if (saveButton) {
                    saveButton.textContent = "Save";
                    saveButton.style.backgroundColor = "";
                }
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(error => {
            console.error("Erreur lors de l'enregistrement :", error);
            alert("Erreur réseau.");
        });
} */
        function saveEventData() {
            const form = document.getElementById("event-form");
            const inputs = form.querySelectorAll("input[data-path]");
            let jsonData = { event: {} };
        
            const checkboxGroups = {};
        
            inputs.forEach(input => {
                const path = input.getAttribute("data-path");
        
                if (input.type === 'checkbox') {
                    if (!checkboxGroups[path]) checkboxGroups[path] = [];
        
                    if (input.checked) {
                        checkboxGroups[path].push(input.value); // on stocke bien les IDs, pas des booléens
                    }
                } else {
                    let value = input.value;
        
                    // Conversion des valeurs booléennes "true"/"false" => true/false
                    if (value === 'true') value = true;
                    if (value === 'false') value = false;
        
                    setJsonValue(jsonData.event, path, value);
                }
            });
        
            // Injecter les groupes de checkboxes (après la boucle)
            for (const path in checkboxGroups) {
                setJsonValue(jsonData.event, path, checkboxGroups[path]);
            }
        
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
                    if (saveButton) {
                        saveButton.textContent = "Save";
                        saveButton.style.backgroundColor = "";
                    }
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
    saveButton = document.getElementById("save-button");

    console.log("form:", form);  // Vérification de l'élément form

    if (form && typeof formConfig === 'object' && typeof eventData === 'object') {
        // Vérification de l'existence de l'élément parent
        if (form instanceof HTMLElement) {
            console.log("formConfigEvent dans generateEventForm:", formConfig.event);
            //generateEventForm(eventData.event, form, formConfig.event);
            console.log("Event brut :", eventData.event);
            generateEventForm(eventData.event, form, "event");
            
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
