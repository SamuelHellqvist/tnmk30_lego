// javascript dokumentet för hela filen
/*Popup funktion*/

function popupFunction(){
    var popup = document.getElementById("myPopup");

    if (popup.style.display === "block") {
        popup.style.display = "none";
      } else {
        popup.style.display = "block";
      }
}