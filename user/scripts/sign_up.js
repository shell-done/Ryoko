// \file sign_up.js
// Script de la page d'inscprition de l'utilisateur

// Appelé lorsque la page est complètement chargée
$(document).ready(function() {
  // Liste les pays disponibles pour l'inscription
  ajaxRequest("GET", "ajax/request.php/countries/", function(ajaxResponse) {
    let countries = JSON.parse(ajaxResponse);
    let text = "";

    for(let i=0; i<countries.length; i++)
      text += "<option value='" + countries[i].iso_code + "'>" + countries[i].name + "</option>";

    if(countries.length == 0)
      text = "<option value='err' disabled selected>Aucun pays disponible</option>";

    $("#inputCountry").html(text);
  });
});
