// \file countries.js
// Script de la page de pays

//Lancé au démarrage de la page
$(document).ready(function(){
  //Affiche le popup d'information si besoin
  if(!$("#info-modal").length == 0)
    $("#info-modal").modal("show");
});

// Demande une supression de pays
function deleteCountry(id) {
  $("#del-form-input").val(id);
  $("#del-form").submit();
}

let prevCountry = null;

// Affiche les champs pour éditer un pays
// \param iso Le code iso de la ligne à modifier
function editCountry(iso) {
  if(prevCountry !== null)
    cancelCountry()

  let formQuery = "#country-" + iso;

  let country = {
    prev_iso: iso,
    iso_code: iso,
    name: $(formQuery + " .name").text()
  }

  $(formQuery + " .iso").html("<input id='iso-" + country.iso_code +"' type='text' maxlength='3' value='" + country.iso_code + "'>");
  $(formQuery + " .name").html("<input id='name-" + country.iso_code + "' type='text' maxlength='64' value='" + country.name + "'>");

  prevCountry = country;

  $(formQuery + " button[name='edit-country']").replaceWith("<button type='button' name='save-country' onclick=saveCountry('" + iso + "')> Enregister </button>");
  $(formQuery + " button[name='delete-country']").replaceWith("<button type='button' name='cancel-country' onclick=cancelCountry('" + iso + "')> Annuler </button>");
}

// Modifie les données d'un pays
// \param country Le code iso de la ligne à modifier
function setCountryData(country) {
  let formQuery = "#country-" + country.prev_iso;

  $(formQuery + " .iso").text(country.iso_code);
  $(formQuery + " .name").text(country.name);

  $(formQuery + " button[name='save-country']").replaceWith("<button type='button' name='edit-country' onclick=editCountry('" + country.iso_code + "')> Modifier </button>");
  $(formQuery + " button[name='cancel-country']").replaceWith("<button type='button' name='delete-country' onclick=deleteCountry('" + country.iso_code + "')> Supprimer </button>");

  $(formQuery).attr("id", "country-" + country.iso_code);
  prevCountry = null;
}

// Sauvegarde les modification d'un pays
// \param Le code ISO du pays
function saveCountry(iso) {
  let formQuery = "#country-" + iso;

  let country = {
    prev_iso: iso,
    iso_code: $("#iso-" + iso).val(),
    name: $("#name-" + iso).val()
  }

  setCountryData(country);

  let html = `
    <input name="prev-iso" type="hidden" value="` + country.prev_iso + `"/>
    <input name="new-iso" type="hidden" value="` + country.iso_code + `"/>
    <input name="new-name" type="hidden" value="` + country.name + `"/>
  `;

  $("#update-form").html(html);
  $("#update-form").submit();
  $("#update-form").html("");
}

// Annule les modification d'un pays
function cancelCountry() {
  setCountryData(prevCountry);
}
