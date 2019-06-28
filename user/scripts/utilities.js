// \file utilities.js
// Scripts utiles pour toutes les pages

// Appelé lorsque la page est complètement chargée
$(document).ready(function() {
  // Demande les informations de l'utilisateur
  ajaxRequest("GET", "ajax/request.php/user/" + userToken, showUser);
});

// Transforme une date JS en string utilisable pour l'input de type date
// \param Un objet date JS
// \return Un string formatée pour l'input de type date
function getInputDate(date) {
  let year = date.getFullYear();
  let month = (date.getMonth()+1).toString().padStart(2, '0');
  let day = date.getDate().toString().padStart(2, '0');

  return year + "-" + month + "-" + day;
}

// Transforme une date utilisable par l'input de type date en un string
// \param Un string formattée pour l'input de type date
// return Un string représentant une date formatée en JJ/MM/AAAA
function getFrenchDate(inputDate) {
  let arr = inputDate.split("-");

  if(arr.length != 3)
    return "";

  return arr[2] + "/" + arr[1] + "/" + arr[0];
}

// Affiche un popup d'information
// \param title Titre du message
// \param content Contenu du popup
// \param isError Définit s'il s'agit d'un message d'erreur ou non
function showInfo(title, content, isError = false) {
  $(".modal:not(#info-modal)").modal("hide"); // On cache les autres popup

  if(isError) // En cas d'erreur, on passe le titre en rouge
    $("#info-modal .modal-title").css("color", "#E60000");
  else
    $("#info-modal .modal-title").removeAttr("style");

  // Rempli le popup
  $("#info-modal .modal-title").html(title);
  $("#info-modal .modal-body").html(content);
  $("#info-modal").modal("show");
}

// Remplis les options de pays pour un select ou une datalist
function showCountries(ajaxResponse) {
  var countries = JSON.parse(ajaxResponse);
  var text = "";

  text += "<option value='ALL'>Tous</option>";
  for(var i=0; i<countries.length; i++)
    text += "<option value='" + countries[i].iso_code + "'>" + countries[i].name + "</option>";

  $("#search-country").html(text);

  setResearchParameters();
}

// Initialise les paramètres dans la barre de recherche
function initResearchBanner() {
  ajaxRequest("GET", "ajax/request.php/countries/", showCountries);

  $("#search-departure").val(getInputDate(new Date()));
  $("#search-departure").attr("min", getInputDate(new Date()));

  $("#search-price").on("input", function () {
    var value = $(this).val();

    if(value != 5000)
      value += " €";
    else
      value = "Tous";

    $("#search-price-value").text(value);
  });
}

// Récupère les paramètres dans la barre de recherche
function getResearchParameters() {
  var researchData = {
    country : $("#search-country option:selected").text(),
    countryCode : $("#search-country").val(),
    duration: $("#search-duration option:selected").text(),
    durationInDays : $("#search-duration").val(),
    departure : $("#search-departure").val(),
    price : $("#search-price").val()
  }

  return researchData;
}

// Place les paramètres dans la barre de recherche
function setResearchParameters() {
  /* Source : https://stackoverflow.com/questions/12049620/how-to-get-get-variables-value-in-javascript */
  var $_GET = [];
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value){$_GET[name] = value;});
  /* ------------------------ */

  // Utilise les variables dans l'url pour remplir l'url
  $("#search-country").val($_GET["country"] ? $_GET["country"] : "ALL");
  $("#search-duration").val($_GET["duration"] ? $_GET["duration"] : "ALL");

  if($_GET["departure"])
    $("#search-departure").val($_GET["departure"]);

  $("#search-price").val($_GET["price"] ? $_GET["price"] : 5000);
  $("#search-price").trigger("input");

  if(startResearchOnLoad)
    $("#search-button").trigger("click");
}

// Affice les informations de l'utilisateur
// \param ajaxResponse La réponse Ajax
function showUser(ajaxResponse) {
  var user = JSON.parse(ajaxResponse);

  $("#navbar-user").text(user.first_name + " " + user.name);
  $(".ui-name").text(user.name);
  $(".ui-first-name").text(user.first_name);
  $(".ui-birthdate").text(user.birth_date);
  $(".ui-country").text(user.country);
  $(".ui-city").text(user.city);
  $(".ui-zipcode").text(user.zip_code);
  $(".ui-street").text(user.street);
  $(".ui-phone").text(user.phone);
  $(".ui-email").text(user.email);
}
