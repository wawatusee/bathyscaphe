/**
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 *                                --- EDITABLE ELEMENT ---- (abstract parent class)
 *
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 */
import EditableItem from "./EditableItem.js";

const CSS_Editable = `
:host {
}
#toolbox button {
  font-size: 1em;
}
.altered {
  background-color: #ffedd5;
}
.saved {
  background-color: #ecfccb;
}
`;
const HTML_Editable = `
<div id="toolbox">
  <span id="out-edit">
  <button id="edit-button">🖊️</button>
  </span>
  <span id="in-edit">
  <button id="quit-button">⬅️</button>
  <button id="save-button" disabled>✔️</button>
  <button id="reset-button" hidden>🔁</button>
  </span>
</div>
<div id="wrapper" hidden "></div>`;

export default class EditableElement extends HTMLElement {
  constructor(HTML_child, CSS_child, handleSave) {
    super();
    const shadow = this.attachShadow({ mode: "open" });
    shadow.innerHTML = HTML_Editable;

    // set style CSS
    const style = document.createElement("style");
    style.innerHTML = CSS_Editable.concat(CSS_child);
    shadow.appendChild(style);

    // get the wrapper and inject child HTML
    const wrapperElement = shadow.getElementById("wrapper");
    wrapperElement.innerHTML = HTML_child;

    //
    // privates variables
    //
    let _editableItems = [];
    let _specificItem = null;
    let _isAltered = false;

    //
    // define the toolbox
    //
    const outEditToolbox = shadow.getElementById("out-edit");
    const inEditToolbox = shadow.getElementById("in-edit");
    const editButton = shadow.getElementById("edit-button");
    const quitButton = shadow.getElementById("quit-button");
    const resetButton = shadow.getElementById("reset-button");
    const saveButton = shadow.getElementById("save-button");

    const setStateEdit = (isOnEdit) => {
      outEditToolbox.style.display = isOnEdit ? "none" : "inline";
      inEditToolbox.style.display = isOnEdit ? "inline" : "none";
      wrapperElement.style.display = isOnEdit ? "block" : "none";
    };

    editButton.addEventListener("click", (evt) => {
      evt.stopPropagation();
      setStateEdit(true);
    });
    saveButton.addEventListener("click", (evt) => {
      evt.stopPropagation();
      try {
        handleSave();
        // setStateEdit(false); // keeping in edit mode after safe action
        this.setAltered(false);
        this.displayResetButton(false);
        _editableItems.forEach((item) => item.save());
      } catch (e) {
        alert(e);
      }
    });
    quitButton.addEventListener("click", (evt) => {
      evt.stopPropagation();
      //TODO: reset all ???
      setStateEdit(false);
    });

    resetButton.onclick = (evt) => {
      evt.stopPropagation;
      evt.target.style.display = "none";
      if (_specificItem) {
        _specificItem.reset();
      } else {
        _editableItems.forEach((item) => item.reset());
      }
    };

    //
    // publics methods
    //
    this.displayResetButton = (display) => {
      resetButton.style.display = display ? "inline" : "none";
    };

    this.setAltered = (value, forced) => {
      if (_isAltered != value) {
        if (forced) {
          _isAltered = value;
        } else {
          _isAltered = _editableItems.some((item) => item.getAltered());
        }
        saveButton.disabled = !_isAltered;
        this.displayResetButton(_isAltered);
      }
    };

    this.addEditableItem = (element, linkedElement, key) => {
      _editableItems.push(
        new EditableItem(element, linkedElement, this.setAltered, key)
      );
    };

    this.setSpecificItemByKey = (keyItem) => {
      _specificItem = _editableItems.find((item) => item.getKey() == keyItem);
      // console.log("set specific ****", keyItem, _specificItem);
      this.setAltered(_specificItem.getAltered(), true);
    };

    this.reset = () => {
      _editableItems.forEach((item) => item.reset());
    };

    //
    // Initialise
    //
    setStateEdit(false);
  }
}
