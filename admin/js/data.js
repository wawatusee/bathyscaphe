const obj = db_json;

export const getActivityById = (id) =>
  obj[1].activities?.find((a) => a.id == id);

export const getRefs = () => obj[0].refs;

export const uptadeActivityByField = (activityId, field, data, parent) => {
  const activity = obj[1].activities?.find((a) => a.id == activityId);
  if ( parent) {
    activity[parent][field] = data;
  } else {
    activity[field] = data;
  }
  return obj[1]
};

export const sendUpdateActivity = async (activityData) => {
  console.log('send update activity ', activityData);
  postJSON(activityData);
}

// export const sendUpdateActivityById = (activityId) => {
//   const activity = getActivityById(activityId)
//   console.log('send update activity by id ', activity)
// }

async function postJSON(data) {

  const jsonData = JSON.stringify(data);
  // console.log('json data: ', jsonData);

  try {

      const response = await fetch("activity-controller.php", {
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