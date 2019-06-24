var travelDisplayedID = null;

$(document).ready(function(){
  /* Source : https://stackoverflow.com/questions/12049620/how-to-get-get-variables-value-in-javascript */
  var $_GET = [];
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value){$_GET[name] = value;});
  /* ------------------------ */

  if($_GET["country"])
    $("#search-country").val($_GET["country"]);

  if($_GET["duration"])
    $("#search-duration").val($_GET["duration"]);

  if(typeof travelData !== "undefined") {
    showPopup(travelData);
  }
});

function getPopup(id) {
  if(id == travelDisplayedID)
    $("#travel-modal").modal("show");
  else
    window.location.href = "?travel=" + id;
}

function showPopup(travel) {
  travelDisplayedID = travel.id_travel;
  $(".travel-modal-user-info").hide();

  $("#travel-modal .modal-title").text(travel.title);
  $(".travel-modal-description").text(travel.description);
  $(".tmi-country").text(travel.country);
  $(".tmi-duration").text(travel.duration + " jours");
  $(".tmi-cost").text(travel.cost + " €");

  if(travel.img_list.length == 0)
    $("#travel-modal-img").attr("src", "img/default_thumb.png");
  else
    $("#travel-modal-img").attr("src", travel.img_list[0]);

  var thumbsText = "";
  for(let i=0; i < travel.img_list.length; i++)
    thumbsText += `<img src="` + travel.img_list[i] + `" />`;

  $(".travel-modal-thumbs").html(thumbsText);
  $(".travel-modal-thumbs img").unbind("click").click(function() {
    $("#travel-modal-img").attr("src", $(this).attr("src"));
  })

  if(travel.validation_status === false) {
    $("#book-button").attr("class", "travel-" + travel.id_travel);
    $("#book-button").removeAttr("disabled");
  } else {
    $("#book-button").attr("class", "");
    $("#book-button").attr("disabled", "true");
  }

  $("#travel-modal").modal("show");
}
