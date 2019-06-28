// \file booking.js
// Script de la page de réservation
var mode = null;

// Appelé lorsque la page est complètement chargée
$(document).ready(function(){
  // Affiche le popup d'info si nécessaire
  if(!$("#info-modal").length == 0)
    $("#info-modal").modal("show");

  //Affiche et permet le traitement des boutons de tri
  $(".sort-bookings button").unbind("click").click(function(){
    $(".sort-bookings button").removeClass("active");
    $(this).addClass("active");

    $(".booking-row").hide();

    mode = $(this).val();

    switch(mode) {
      case "all":
        $(".booking-row").show();
        break;

      case "waiting":
        $(".status-waiting").show();
        break;

      case "accepted":
        $(".status-accepted").show();
        break;

      case "denied":
        $(".status-denied").show();
        break;
    }
  });

  // Lis les paramètres dans l'url
  var $_GET = [];
  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value){$_GET[name] = value;});
  if(['all', 'accepted', 'waiting', 'denied'].includes($_GET["mode"]))
    mode = $_GET["mode"];
  else
    mode = "all";

  $("button[value='" + mode + "']").click();
});

//Accepte une réservation
// \param id ID du voyage
// \param email Email de l'utilisateur
function accept(id, email) {
  $("input[name='userEmail']").val(email);
  $("input[name='travelId']").val(id);
  $("input[name='status']").val("accept");
  $("input[name='sort']").val(mode);
  $("#set-status").submit();
}

//Refuse une réservation
// \param id ID du voyage
// \param email Email de l'utilisateur
function deny(id, email) {
  $("input[name='userEmail']").val(email);
  $("input[name='travelId']").val(id);
  $("input[name='status']").val("deny");
  $("input[name='sort']").val(mode);
  $("#set-status").submit();
}
