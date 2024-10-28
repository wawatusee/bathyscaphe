// import { postJSON } from "./tests/fetch.js";
import { getRefs, getActivityById, uptadeActivityByField, sendUpdateActivity } from "./data.js";
import {
  FieldsEditableElement,
  InputEditableElement,
  CheckEditableElement,
  TabsEditableElement,
  OptionsEditableElement,
} from "./components/index.js";

const btn = document.querySelector('#btn-update');
// makeFetchButton(btn);

function loadActivityById(id) {
  const activityData = getActivityById(id);
  const refs = getRefs();
  const btn = document.querySelector('#btn-update');
  btn.onclick = async () => {
    sendUpdateActivity(activityData)
  }

  /**
   * FONCTIONS UPDATE DISPLAY HTML
   */

  const formatingText = (format, text) => (format ? format(text) : text);
/*Ensemble de fonctions pour la mise en forme du html,
 - target : l'élément du DOM  à modifier,
 - result : nouvelle valeur saisie par l'utilisateur,
 -  refs(optionnel) : ensemble des valeurs, table externe
 - format : fonction de formatage du texte*/
  const updateHTML = {
    empty: () => ( null ),
    text: ({ target, result, format }) => {
      target.innerHTML = formatingText(format, result);
    },

    list: ({ target, result, refs, format }) => {
      //We need a child element for clone it
      const existingCount = target.childElementCount;
      if (existingCount < 1)
        throw new error(
          "a option's field must have minimum one element on the HTML page"
        );
      // go
      const model = target.firstElementChild.cloneNode(true);
      const elements = [];
      result.forEach((item) => {
        const clone = model.cloneNode(true);
        clone.innerText = formatingText(format, refs[item]);
        elements.push(clone);
      });
      target.replaceChildren(...elements);
    },

    listConcated: ({ target, result, refs, format }) => {
      // capture the first (child) ELEMENT in the target (text must be in first position)
      // and retrieve its HTML contents's  for rendering
      const childNodes = target.childNodes;
      const childrenRender =
        childNodes?.length > 1 ? childNodes[1].outerHTML : "";

      let content = "";
      result.forEach((item) => {
        content += formatingText(format, refs[item]);
        content += childrenRender;
      });
      target.innerHTML = content;
    },

    link: ({ target, result, format }) => {
      target.innerText = formatingText(format, result.text);
      target.href = result.href;
    },

  };

  /**
   *  MAPPING FIELDS
   */

  const elements = {
    title: {
      component: InputEditableElement,
      options: {},
      handleUpdateHTML: updateHTML.text,
    },
    types: {
      refs: "types",
      multilangage: true,
      component: OptionsEditableElement,
      options: {},
      handleUpdateHTML: updateHTML.list,
    },
    description: {
      multilangage: true,
      component: TabsEditableElement,
      options: {
        multiligne: true,
        defaultTab: document.documentElement.lang,
      },
      handleUpdateHTML: updateHTML.text,
    },
    organisateur: {
      component: FieldsEditableElement,
      handleUpdateHTML: updateHTML.link,
      functionHTML: (result) => ({
        text: result.name,
        href: result.link,
      }),
    },
    language: {
      refs: ["fr", "nl", "en"],
      component: OptionsEditableElement,
      options: {},
      handleUpdateHTML: updateHTML.listConcated,
      format: (t) => ` |${t}| `,
    },
    dates: {
      refs: "dates",
      multilangage: true,
      component: OptionsEditableElement,
      options: {},
      handleUpdateHTML: updateHTML.listConcated,
      // format: (t) => `${t} </br> `,
    },
    horaire: {
      component: InputEditableElement,
      options: {},
      handleUpdateHTML: updateHTML.text,
    },
    price: {
      component: InputEditableElement,
      options: {},
      handleUpdateHTML: updateHTML.text,
    },
    booking: {
      component: CheckEditableElement,
      options: { label: refs.reservation[document.documentElement.lang][0] },
      handleUpdateHTML: updateHTML.text,
      functionHTML: (result) => {
        const index = result ? 1 : 2
        return refs.reservation[document.documentElement.lang][index]
      }
    },
    bookinglinks: {
      component: FieldsEditableElement,
      handleUpdateHTML: updateHTML.text,
      functionHTML: (result) => {
        let html = ""
        for (const [key, value] of Object.entries(result)) {
          if (value && value.trim() !== "") {
            html += `${key.charAt(0).toUpperCase() + key.slice(1)} : ${value} `
          }
        }
        if (html !== "") {
          html = "Booking via " + html
        }
        return html
      }
    },
    adress: {
      component: FieldsEditableElement,
      parent: "location",
      handleUpdateHTML: updateHTML.text,
      functionHTML: ({ number, street, town, postcode, lieudit }) => {
        return `${lieudit}. </br> ${number}, ${street} </br> ${postcode} ${town}`
      }
    },
    coordonates: {
      component: FieldsEditableElement,
      parent: "location",
      handleUpdateHTML: updateHTML.empty
      /*"coordonates":{
        "lat": 50.8677651,
        "lon": 4.340492
    }*/
    }

  };

  // "title"        ok
  // "id"           ok
  // "types"        ok
  // "description"  ok
  // "language"     bug -> data
  // "illustration"
  // "organisateur" ok
  // "dates"        ok
  // "horaire"      ok
  // "booking"      ok
  // "price"        ok
  // "location"     ok
  // "bookinglinks" ok

  for (const [field, element] of Object.entries(elements)) {
    const target = document.querySelector(`[data-field="${field}"]`);

    const paramRefs = element.refs
      ? Array.isArray(element.refs) ? element.refs :
        element.multilangage
          ? refs[element.refs][document.documentElement.lang]
          : refs[element.refs]
      : null;

    const formatingResult = (result) => {
      if (element.multilangage && !Array.isArray(result)) {
        result = result[document.documentElement.lang];
      }
      if (element.functionHTML) {
        return element.functionHTML(result);
      }
      return result;
    };

    const data = element.parent ? activityData[element.parent][field] : activityData[field]

    target?.after(
      new element.component({
        handleUpdate: (result) => {
          uptadeActivityByField(id, field, result, element.parent);
          element.handleUpdateHTML({
            target,
            result: formatingResult(result),
            refs: paramRefs,
            format: element.format,
          });
        },
        data: data,
        ...element.options,
        refs: paramRefs,
      })
    );
  }
}

loadActivityById(+document.querySelector(".cardId").innerText);

const elems = document.querySelectorAll('[data-field]')
const fields = Array.from(elems, elem => elem.dataset.field)

console.log('fields data: .. ', fields)