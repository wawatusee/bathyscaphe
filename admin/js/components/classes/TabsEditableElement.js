/**
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 *
 *                                --- TABS EDITABLE ELEMENT ----
 *
 *  ////////////////////////////////////////////////////////////////////////////////////////////////////
 */
import { ALTERED } from "./_constantes.js";
import EditableElement from "./EditableElement.js";

const CSS_Tabs = `
#tabs-header {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}
#tabs-header button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}
#tabs-header button:hover {
  background-color: #ddd;
}
#tabs-header button.active {
  background-color: #ccc;
}
#tabs-content {
  /* display: none; */
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
.content-item {
  display: none;
  overflow: hidden;
  width: 100%;
  height: 200px;
  resize: none;
  background-color: #ecfccb;
}
.content-item.active {
  display: block;
}
.content-item.${ALTERED} {
  background-color: #ffedd5;
}
button.${ALTERED}::after {
  content: " *";
}
`;

const HTML_Tabs = `
<div id="tabs-header"></div>
<div id="tabs-content"></div>
`;

export default class TabsEditableElement extends EditableElement {
  constructor(params) {
    super(HTML_Tabs, CSS_Tabs, handleSave);
    const shadow = this.shadowRoot;
    const { data, handleUpdate, defaultTab, multiligne } = { ...params };

    function handleSave() {
      //call updating callback function and update local data TODO????
      getContents().forEach((content) => {
        data[content.key] = content.value;
      });
      handleUpdate(data);
    }

    const getHeaders = () => shadow.querySelectorAll("#tabs-header button");
    const getContents = () => shadow.querySelectorAll(".content-item");

    const setActiveTab = (header) => {
      getHeaders().forEach((h) => {
        if (h == header) {
          h.classList.add("active");
          h.content.classList.add("active");
          this.setSpecificItemByKey(h.key);
        } else {
          h.classList.remove("active");
          h.content.classList.remove("active");
        }
      });
    };

    /**
     *  Create and initialize elements (headers and contents)
     *  -----------------------------------------------------
     */
    const headerWrapper = shadow.querySelector("#tabs-header");
    const contentWrapper = shadow.querySelector("#tabs-content");
    const inputType = multiligne ? "textarea" : "input";

    const onChange = (altered) => {
      this.setAltered(altered);
    };

    for (const [key, value] of Object.entries(data)) {
      const tabId = `tab-${key}`;

      const headerButton = document.createElement("button");
      const contentInput = document.createElement(inputType);

      // the headers
      headerButton.key = key;
      headerButton.innerText = key;
      headerButton.setAttribute("for", tabId);
      headerButton.content = contentInput;
      headerButton.onclick = () => {
        setActiveTab(headerButton);
      };
      headerWrapper.appendChild(headerButton);

      // the contents
      contentInput.classList.add("content-item");
      contentInput.value = value;
      contentInput.key = key;
      contentInput.setAttribute("id", tabId);

      contentWrapper.appendChild(contentInput);

      this.addEditableItem(contentInput, headerButton, key);

      if (key === defaultTab) {
        setActiveTab(headerButton);
      }
    }
  }
}

customElements.define("tabs-editable", TabsEditableElement);
