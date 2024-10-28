/**
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 *                                --- FIELDS EDITABLE ELEMENT ----
 *
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 */
import { ALTERED } from "./_constantes.js";
import EditableElement from "./EditableElement.js";

const CSS_Fields = `
#fields {
  padding: 1em;
}
input.cell {
  min-width: 400px;
}
.table {
  display: table;
}

.row {
  display: table-row;
}

.cell {
  display: table-cell;
  padding: 0.5em;
}


label.${ALTERED}::after {
  content: "*";
}

`;

const HTML_Fields = `
<div id="fields" class="table"></div>
`;

export default class FieldsEditableElement extends EditableElement {
  constructor(params) {
    super(HTML_Fields, CSS_Fields, handleSave);
    const shadow = this.shadowRoot;
    const { data, handleUpdate } = { ...params };

    function handleSave() {
      //call updating callback function and update local data



      fieldsInputs.forEach((input) => {data[input.key] = input.value;});
      handleUpdate(data);
    }

    /**
     *  Create and initialize element
     *  -----------------------------
     */

    const fields = shadow.querySelector("#fields");

    for (const [key, value] of Object.entries(data)) {
      //create a field
      const field = document.createElement("div");
      field.classList.add("row");

      const fieldId = `field-${key}`;

      const input = document.createElement("input");
      input.classList.add("cell");
      input.setAttribute("id", fieldId);
      input.value = value;
      input.key = key;

      const label = document.createElement("label");
      label.classList.add("cell");
      label.setAttribute("for", fieldId);
      label.innerText = key;

      field.append(label, input);
      fields.append(field);
      this.addEditableItem(input, label);
    }

    const fieldsInputs = shadow.querySelectorAll("input");
  }
}

customElements.define("fields-editable", FieldsEditableElement);
