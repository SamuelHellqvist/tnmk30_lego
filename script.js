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