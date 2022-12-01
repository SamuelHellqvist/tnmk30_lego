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




/*Samuels lilla script*/

/* This scirpt originates from w3schools */
let topbutton = document.getElementById("topBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
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