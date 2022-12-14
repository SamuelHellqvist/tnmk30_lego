// javascript dokumentet för hela filen
/*Popup funktion*/

function popupFunction(id){
    console.log(id.id);
    var popup = document.getElementById(id.id);
   
    if(id.id=="howToUsePopup"){
        aboutUsPopup.style.display = "none";
        cookiesPopup.style.display = "none";
    }
    else if (id.id=="aboutUsPopup") {
        howToUsePopup.style.display = "none";
        cookiesPopup.style.display = "none";
    }
    else if (id.id=="cookiesPopup") {
        howToUsePopup.style.display = "none";
        aboutUsPopup.style.display = "none";
    }

    if (popup.style.display === "block") {
        popup.style.display = "none";
      } else {
        popup.style.display = "block";
      }
}

function closePopup(id){
  document.getElementById(id.id).style.display = "none";
}

/*NOTE This scirpt originates from w3schools.com NOTE*/
let topbutton = document.getElementById("topBtn");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
    topbutton.style.display = "block";
  } else {
    topbutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

topbutton.addEventListener("click", topFunction);