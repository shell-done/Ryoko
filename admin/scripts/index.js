$(document).ready(function(){
  /* Source : https://stackoverflow.com/questions/12049620/how-to-get-get-variables-value-in-javascript */
  var $_GET = [];
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value){$_GET[name] = value;});
  /* ------------------------ */

  if($_GET["country"])
    $("#search-country").val($_GET["country"]);

  if($_GET["duration"])
    $("#search-duration").val($_GET["duration"]);

  if(travelDisplayedID)
    $("#travel-modal").modal("show");

  if(!$("#info-modal").length == 0)
    $("#info-modal").modal("show");
});

function getPopup(id) {
  if(id == travelDisplayedID)
    $("#travel-modal").modal("show");
  else
    window.location.href = "?travel=" + id;
}

let travelBeforeEdit = null;

function editTravel() {
  let travel = {
    title: $("#travel-modal .modal-title").text().trim(),
    description: $(".travel-modal-description").text().trim(),
    country: $(".tmi-country").text().trim(),
    duration: parseInt($(".tmi-duration").text().trim().split(" ")[0]),
    cost: parseInt($(".tmi-cost").text().trim().split(" ")[0]),
  }

  travelBeforeEdit = travel;

  $(".modal-title").html("<input type='text'>");
  $(".modal-title input").val(travel.title);
  $(".travel-modal-description").html("<textarea></textarea>");
  $(".travel-modal-description textarea").val(travel.description);

  let countryCodes = Object.keys(countryList);
  let countryc;
  let text = "<select>";
  for(let i=0; i<countryCodes.length; i++) {
    text += "<option value='" + countryCodes[i] + "'>" + countryList[countryCodes[i]] + "</option>";
    if(travel.country == countryList[countryCodes[i]])
      countryc = countryCodes[i];
  }
  text += "</select>";

  $(".tmi-country").html(text);
  $(".tmi-country select").val(countryc);

  $(".tmi-duration").html("<input type='number' value='" + travel.duration + "'> jours");
  $(".tmi-cost").html("<input type='number' value='" + travel.cost + "'> €");

  $("#edit-travel").replaceWith('<button id="save-travel" type="submit" onclick="saveTravel();">Enregistrer</button>');
  $("#delete-travel").replaceWith('<button id="cancel-travel" type="button" onclick="cancelTravel();">Annuler</button>');
}

function setTravelData(travel) {
  $("#travel-modal .modal-title").text(travel.title);
  $(".travel-modal-description").text(travel.description);
  $(".tmi-country").text(travel.country);
  $(".tmi-duration").text(travel.duration);
  $(".tmi-cost").text(travel.cost);

  $("#save-travel").replaceWith('<button id="edit-travel" type="button" onclick="editTravel();">Modifier</button>');
  $("#cancel-travel").replaceWith('<button id="delete-travel" type="submit">Supprimer</button>');

  travelBeforeEdit = null;
}

function saveTravel() {
  let travel = {
    title: $(".modal-title input").val(),
    description: $(".travel-modal-description textarea").val(),
    countryCode: $(".tmi-country select").val(),
    country: $(".tmi-country option:selected").text(),
    duration: $(".tmi-duration input").val(),
    cost: $(".tmi-cost input").val()
  }

  $("#tm-input-list").html("");
  $("#tm-input-list").append("<input type='hidden' name='title'>");
  $("#tm-input-list input[name='title']").val(travel.title);

  $("#tm-input-list").append("<input type='hidden' name='description'>");
  $("#tm-input-list input[name='description']").val(travel.description);

  $("#tm-input-list").append("<input type='hidden' name='country'>");
  $("#tm-input-list input[name='country']").val(travel.countryCode);

  $("#tm-input-list").append("<input type='hidden' name='duration'>");
  $("#tm-input-list input[name='duration']").val(travel.duration);

  $("#tm-input-list").append("<input type='hidden' name='cost'>");
  $("#tm-input-list input[name='cost']").val(travel.cost);
  $("#edit-travel-form").submit();

  setTravelData(travel);
}

function cancelTravel() {
  setTravelData(travelBeforeEdit);
}
