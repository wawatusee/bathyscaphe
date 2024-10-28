/***
 * Affiche un button 
 */

export function makeFetchButton(btnElem) {
  btnElem.onclick = async () => {
    const data = { username: "example" };
    // console.log('on click fetch button')
    postJSON(data);
  }

}

//activity-controller.php

export async function postJSON(data) {

  const jsonData = JSON.stringify(data);
  console.log('json data: ', jsonData);

  try {
    const response = await fetch("http://localhost:8000/admin/activity-controller.php", {
      method: "POST", // or 'PUT'
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });

    const result = await response.json();
    console.log("Success:", result);
  } catch (error) {
    console.error("Error:", error);
  }
}

