/**
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 *                                --- EDITABLE ITEM ----
 *
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 */
import { ALTERED } from "./_constantes.js";

export default class EditableItem {
  constructor(element, linkedElement, onChange, key) {
    // get the specific attribute of input type
    const type = element.getAttribute("type");
    const attr = type == "checkbox" ? "checked" : "value";
    // save the inital value of the input
    let initial = element[attr];

    // internal state
    let _isAltered = false;

    element.oninput = () => {
      this.setAltered(initial !== element[attr]);
    };

    // publics methods
    this.setAltered = (altered) => {
      if (altered !== _isAltered) {
        element.classList.toggle(ALTERED);
        linkedElement?.classList.toggle(ALTERED);
        _isAltered = altered;
        if (!altered) {
          element[attr] = initial;
        }
        if (onChange) onChange(altered);
      }
    };
    this.save = () => {
      initial = element[attr];
      this.reset();
    };

    this.getAltered = () => _isAltered;
    this.reset = () => this.setAltered(false);
    this.getKey = () => key;
  }
}
