$(document).ready(function() {
  ajaxRequest("GET", "ajax/request.php/user/" + userToken, showUser);
});

function getInputDate(date) {
  let year = date.getFullYear();
  let month = (date.getMonth()+1).toString().padStart(2, '0');
  let day = date.getDate().toString().padStart(2, '0');

  return year + "-" + month + "-" + day;
}

function getFrenchDate(inputDate) {
  let arr = inputDate.split("-");

  if(arr.length != 3)
    return "";

  return arr[2] + "/" + arr[1] + "/" + arr[0];
}

function showInfo(title, content, isError = false) {
  $(".modal:not(#info-modal)").modal("hide");

  if(isError)
    $("#info-modal .modal-title").css("color", "#E60000");
  else
    $("#info-modal .modal-title").removeAttr("style");

  $("#info-modal .modal-title").html(title);
  $("#info-modal .modal-body").html(content);
  $("#info-modal").modal("show");
}

function showCountries(ajaxResponse) {
  var countries = JSON.parse(ajaxResponse);
  var text = "";

  text += "<option value='ALL'>Tous</option>";
  for(var i=0; i<countries.length; i++)
    text += "<option value='" + countries[i].iso_code + "'>" + countries[i].name + "</option>";

  $("#search-country").html(text);

  setResearchParameters();
}

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

function setResearchParameters() {
  /* Source : https://stackoverflow.com/questions/12049620/how-to-get-get-variables-value-in-javascript */
  var $_GET = [];
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value){$_GET[name] = value;});
  /* ------------------------ */

  $("#search-country").val($_GET["country"] ? $_GET["country"] : "ALL");
  $("#search-duration").val($_GET["duration"] ? $_GET["duration"] : "ALL");

  if($_GET["departure"])
    $("#search-departure").val($_GET["departure"]);

  $("#search-price").val($_GET["price"] ? $_GET["price"] : 5000);
  $("#search-price").trigger("input");

  if(startResearchOnLoad)
    $("#search-button").trigger("click");
}

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
