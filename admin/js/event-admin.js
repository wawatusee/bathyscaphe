function generateEventForm(data, config, parent = document.getElementById("event-form"), path = "") {
    if (config.event) config = config.event; // recentre la config si c’est la config globale
    parent.innerHTML = "";
    for (const key in data) {
        const value = data[key];
        const fullPath = path ? `${path}.${key}` : key;
        const fieldConfig = getNestedConfig(config, fullPath) || {};

        if (typeof value === "object" && !Array.isArray(value)) {
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            generateEventForm(value, config, fieldset, fullPath);
            parent.appendChild(fieldset);
        } else if (Array.isArray(value)) {
            const fieldset = document.createElement("fieldset");
            fieldset.innerHTML = `<legend>${fieldConfig.label || key}</legend>`;
            value.forEach((item, index) => {
                const entryWrapper = document.createElement("fieldset");
                const arrayPath = `${fullPath}[${index}]`;
                generateEventForm(item, fieldConfig.structure, entryWrapper, arrayPath);
                fieldset.appendChild(entryWrapper);
            });

            const addButton = document.createElement("button");
            addButton.type = "button";
            addButton.textContent = "➕ Ajouter un lien";
            addButton.onclick = () => {
                const newIndex = data[key].length;
                const newItem = { name: "", link: "" };
                data[key].push(newItem);

                const entryWrapper = document.createElement("fieldset");
                const arrayPath = `${fullPath}[${newIndex}]`;

                generateEventForm(newItem, fieldConfig.structure, entryWrapper, arrayPath);
                fieldset.insertBefore(entryWrapper, addButton);
            };

            fieldset.appendChild(addButton);
            parent.appendChild(fieldset);
        } else {
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

            if (fieldConfig.readonly) {
                input.readOnly = true;
            }

            label.appendChild(input);
            parent.appendChild(label);
        }
    }
}
