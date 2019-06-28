// \file index.js
// Script de la page principale de l'utilisateur
var startResearchOnLoad = false;

// Appelé lorsque la page est complètement chargée
$(document).ready(function(){
  initResearchBanner(); // Initialise la barre de recherche

  $("#search-button").unbind("click").click(function(event) {
    event.preventDefault(); // On empêche la page de se rafraichir

    let params = getResearchParameters(); // On récupère les paramètres de recherches

    // On redirige vers la page de recherche avec les paramètres dans l'url
    window.location.href = 'research.php?' +
      'country=' + params.countryCode +
      '&duration=' + params.durationInDays +
      '&departure=' + params.departure +
      '&price=' + params.price;
  });
});
