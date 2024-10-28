/**
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 *                                --- OPTIONS EDITABLE ELEMENT ----
 *
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 */

import { ALTERED } from "./_constantes.js";
import EditableElement from "./EditableElement.js";

const CSS_Options = `
#options {
  padding: 1em 0;
  display: flex;
  flex-wrap: wrap;
}
.option {
  margin-left: 1.25em;
  padding: 0.25em 0.75em 0.25em 0;
}
.option.${ALTERED}>label::after {
  position: absolute;
  content: "*";
}
`;

const HTML_Options = `
<div id="options" class="save"></div>
`;

export default class OptionsEditableElement extends EditableElement {
  constructor(params) {
    super(HTML_Options, CSS_Options, handleSave);
    const { data, handleUpdate, refs } = { ...params };

    const shadow = this.shadowRoot;

    function handleSave() {
      const options = [];
      optionsInputs.forEach((option, index) => {
        if (option.checked) {
          options.push(index);
        }
      });
      // !!! si il n'ya aucune option
      if (options.length < 1) {
        throw new Error("vous devez renseigner une option (au minimum)");
        return;
      }
      data.splice(0, 0, ...options);
      handleUpdate(options);
    }

    /**
     *  Create and initialize elements ( headers and contents)
     *  -----------------------------------------------------
     */

    // console.log("Options ...", data, refs);
    const isInOptions = (ref, index) => {
      return data.includes(ref) || data.includes(index);
    };
    const wrapperElement = shadow.querySelector("#options");

    refs.forEach((ref, index) => {
      const div = document.createElement("div");
      const input = document.createElement("input");
      const label = document.createElement("label");
      div.classList.add("option");

      input.setAttribute("id", `toggle-${index}`);
      input.setAttribute("type", "checkbox");
      input.checked = isInOptions(ref, index);
      label.setAttribute("for", `toggle-${index}`);
      label.innerText = ref;

      div.append(input, label);
      wrapperElement.appendChild(div);

      this.addEditableItem(input, div);
    });
    const optionsInputs = shadow.querySelectorAll("#options input");
  }
}

customElements.define("options-editable", OptionsEditableElement);
