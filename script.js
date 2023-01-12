// javascript dokumentet för hela filen
/*Popup funktion*/

function popupFunction(id){
    var popup = document.getElementById(id.id);
  
    //  visar vald popup och döljer resterande
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
//stänger popup om man trycker på samma knapp igen
    if (popup.style.display === "block") {
        popup.style.display = "none";
      } else {
        popup.style.display = "block";
      }
}

//döljer popupen när man trycker på krysset
function closePopup(id){
  document.getElementById(id.id).style.display = "none";
}

/*NOTE This scirpt originates from w3schools.com NOTE*/
let topbutton = document.getElementById("topBtn");

window.onscroll = function() {scrollFunction()}; //tillkallar scrollFunctionen när användaren scrollar

function scrollFunction() {
  if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) { //visar top knappen när man kommit ner på sidan
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


/*NOTE This scirpt originates from w3schools.com NOTE*/
// För slides funktion på how to use
var slideIndex = 1;
showDivs(slideIndex); //visar första bilden

function plusDivs(n) { //tillkallas när man trycker på pil
  showDivs(slideIndex += n); //n = +1 eller -1 beroende på vilken pil
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1} //hamnar på första bilden igen efter man gått igenom alla
  if (n < 1) {slideIndex = x.length} ;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none"; //döljer bilder som inte är rätt index
  }
  x[slideIndex-1].style.display = "block"; //visar bild med rätt index
}

