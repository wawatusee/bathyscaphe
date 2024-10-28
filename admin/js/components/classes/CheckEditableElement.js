/**
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 *                                --- INPUT EDITABLE ELEMENT ----
 *
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 */
import { ALTERED } from "./_constantes.js";
import EditableElement from "./EditableElement.js";

const CSS_Input = `
#input-wrapper {
  padding-top: 1em;
  padding-bottom: 2em;
}
#input-content {
  margin-left: 1em;
}

`;

const HTML_Input = `
<div id="input-wrapper"></div>
`;

export default class CheckEditableElement extends EditableElement {
  constructor(params) {
    super(HTML_Input, CSS_Input, handleSave);
    const { data, handleUpdate, label } = { ...params };
    const shadow = this.shadowRoot;

    function handleSave() {
      //call updating callback function and update local data
      handleUpdate(input.checked);
    }

    /**
     *  Create and initialize element
     *  -----------------------------
     */
    const inputWrapper = shadow.querySelector("#input-wrapper");

    const input = document.createElement('input');
    const legend = document.createElement('span');
    input.setAttribute("id", "input-content");
    input.setAttribute("type", "checkbox");
    input.style.display = "inline-block"
    input.checked = data;

    legend.innerText = label
    inputWrapper.appendChild(legend);
    inputWrapper.appendChild(input);

    this.addEditableItem(input);
  }
}

customElements.define("check-editable", CheckEditableElement);
