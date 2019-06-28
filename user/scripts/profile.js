// \file profile.js
// Script de la page de profil de l'utilisateur

// Appelé lorsque la page est complètement chargée
$(document).ready(function() {
  // Remplace le bouton de réservation pour le status
  $("#book-button").replaceWith(`
      <span id="modal-travel-status"></span>
    `);

  // Récupère les réservations de l'utilisateur courant
  ajaxRequest("GET", "ajax/request.php/bookings/", showBookings, "userToken=" + userToken);
});

// Affiche les réservations renvoyées par la requête Ajax
// \param ajaxResponse La réponse à la requête Ajax
function showBookings(ajaxResponse) {
  var bookings = JSON.parse(ajaxResponse); // Transformation en objet JSON

  var text = "";

  // On affiche toutes les réservations
  for(let i=0; i<bookings.length; i++) {
    // S'il n'y a aucune image, on affiche l'image par défaut. Sinon on affiche la première image
    let thumb = "img/default_thumb.png";
    if(bookings[i].img_list.length != 0)
      thumb = bookings[i].img_list[0];

    let status = "waiting";
    if(bookings[i].validation_status == "ACCEPTED")
      status = "accepted";
    else if(bookings[i].validation_status == "DENIED")
      status = "denied";

    // Traduction du status
    let translations = {
      waiting: "En attente de validation",
      accepted: "Voyage accepté",
      denied: "Voyage refusé"
    };

    // Affichage d'une div correspondant au voyage réservé
    text += `<div id="id-travel-` + bookings[i].travel_id + `" class="travel row" onclick="showTravelModal(` + bookings[i].id_travel + `)">
              <div class="col-md-4"><img src="` + thumb + `" /></div>
              <div class="col-md-8">
                <span class="travel-header">
                  <h3>` + bookings[i].title + ` (` + bookings[i].country + `)</h3>
                  <span class="travel-duration">Durée: ` + bookings[i].duration + ` jours</span>
                </span>
                <p class="travel-description">
                  ` + bookings[i].description + `
                </p>
                <div class="travel-date">
                  <span class="travel-departure">Départ:<br />` + bookings[i].departure_date + `</span>
                  <span class="travel-arrival">Arrivée:<br />` + bookings[i].return_date + `</span>
                  <span class="travel-price">Prix:<br />` + bookings[i].cost + ` €</span>
                </div>

                <span class="travel-status-box">
                  <span></span>
                  <span class="travel-status travel-status-` + status + `">
                    <img src="img/travel_status/` + status+ `.png" />
                    <span>` + translations[status] + `</span>
                  </span>
                </span>
              </div>
            </div>`;
  }

  // Place les réservations sur la page
  $("#bookings-container").html(text);
}

// Demande les informations pour afficher les détails d'un voyage réservé
// \param id Lid du voyage
function showTravelModal(id) {
  ajaxRequest("GET", "ajax/request.php/bookings/" + id, editTravelModal, "userToken=" + userToken);
}

// Rempli le popup du détail d'un voyage et l'affiche
// \param ajaxResponse La réponse de la requête Ajax
function editTravelModal(ajaxResponse) {
  var travel = JSON.parse(ajaxResponse);

  let status = "waiting";
  if(travel.validation_status == "ACCEPTED")
    status = "accepted";
  else if(travel.validation_status == "DENIED")
    status = "denied";

  // Traduction des status
  let translations = {
    waiting: "En attente de validation",
    accepted: "Voyage accepté",
    denied: "Voyage refusé"
  };

  // Remplissage des informations du popup affiché et de celui affiché lors de l'impression
  $("#travel-modal .modal-title").text(travel.title);
  $(".print-content h3").text(travel.title);
  $(".travel-modal-description").text(travel.description);
  $(".print-desc").text(travel.description);
  $(".tmi-country").text(travel.country);
  $(".print-country").text(travel.country);
  $(".tmi-duration").text(travel.duration + " jours");
  $(".print-duration").text(travel.duration + " jours");
  $(".tmi-cost").text(travel.cost + " €");
  $(".print-cost").text(travel.cost + " €");

  // Récupération des la date
  let dep = travel.departure_date.split("/").reverse();
  let ret = travel.return_date.split("/").reverse();

  // Mise au bon format des dates pour les input
  $(".tmi-departure").val(dep[0].padStart(2, '0') + "-" + dep[1].padStart(2, '0') + "-" + dep[2].padStart(2, '0'));
  $(".tmi-departure").attr("readonly", "true");
  $(".tmi-return").val(ret[0].padStart(2, '0') + "-" + ret[1].padStart(2, '0') + "-" + ret[2].padStart(2, '0'));

  // Affiche les dates dans le popup d'impression
  $(".print-departure").text(getFrenchDate($(".tmi-departure").val()));
  $(".print-return").text(getFrenchDate($(".tmi-return").val()));

  // Si aucune image n'est disponible, on affiche une image par défaut
  if(travel.img_list.length == 0) {
    $("#travel-modal-img").attr("src", "img/default_thumb.png");
    $(".print-thumb img").attr("src", "img/default_thumb.png");
  } else {
    $("#travel-modal-img").attr("src", travel.img_list[0]);
    $(".print-thumb img").attr("src", travel.img_list[0]);
  }

  var thumbsText = "";
  for(let i=0; i < travel.img_list.length; i++)
    thumbsText += `<img src="` + travel.img_list[i] + `" />`;

  $(".travel-modal-thumbs").html(thumbsText);
  $(".travel-modal-thumbs img").unbind("click").click(function() {
    $("#travel-modal-img").attr("src", $(this).attr("src"));
  })

  // Si le statut de validation n'est pas défini, on affiche le bouton de réservation
  if(travel.validation_status === false) {
    $("#book-button").attr("class", "travel-" + travel.id_travel);
    $("#book-button").removeAttr("disabled");
  } else {
    $("#book-button").attr("class", "");
    $("#book-button").attr("disabled", "true");
  }

  // On place les informations du status dans la div
  $("#modal-travel-status").html(
    `<span class="modal-travel-status travel-status travel-status-` + status + `">
      <img src="img/travel_status/` + status+ `.png" />
      <span>` + translations[status] + `</span>
    </span>`
  );

  $(".print-msg p").text("Statut de votre demande : " + translations[status]);

  // Finalement, on affiche le modal
  $("#travel-modal").modal("show");
}
