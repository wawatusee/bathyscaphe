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
  display: block;
  overflow: hidden;
  width: 100%;
}

`;

const HTML_Input = `
<div id="input-wrapper"></div>
`;

export default class InputEditableElement extends EditableElement {
  constructor(params) {
    super(HTML_Input, CSS_Input, handleSave);
    const { data, handleUpdate, multiligne } = { ...params };
    const shadow = this.shadowRoot;

    function handleSave() {
      //call updating callback function and update local data
      handleUpdate(input.value);
    }

    /**
     *  Create and initialize element
     *  -----------------------------
     */
    const inputWrapper = shadow.querySelector("#input-wrapper");
    const inputType = multiligne ? "textarea" : "input";

    const input = document.createElement(inputType);
    input.setAttribute("id", "input-content");
    input.value = data;

    inputWrapper.appendChild(input);

    this.addEditableItem(input);
  }
}

customElements.define("input-editable", InputEditableElement);
