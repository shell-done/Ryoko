$(document).ready(function() {
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
