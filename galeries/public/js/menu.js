//Menu responsive
function responsiveMenu() {
    let x = document.getElementById("responsiveMenu");
    if (x.className === "responsiveMenu") {
      x.className += " responsive";
    } else {
      x.className = "responsiveMenu";
    }
  }