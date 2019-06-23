$(document).ready(function() {
  $("#book-button").replaceWith(`
      <span id="modal-travel-status"></span>
    `);

  ajaxRequest("GET", "ajax/request.php/bookings/", showBookings, "userToken=" + userToken);
});

function showBookings(ajaxResponse) {
  var bookings = JSON.parse(ajaxResponse);

  var text = "";

  for(let i=0; i<bookings.length; i++) {
    let thumb = "img/default_thumb.png";
    if(bookings[i].img_list.length != 0)
      thumb = bookings[i].img_list[0];

    let status = "waiting";
    if(bookings[i].validation_status == "ACCEPTED")
      status = "accepted";
    else if(bookings[i].validation_status == "DENIED")
      status = "denied";

    let translations = {
      waiting: "En attente de validation",
      accepted: "Voyage accepté",
      denied: "Voyage refusé"
    };

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

  $("#bookings-container").html(text);
}

function showTravelModal(id) {
  ajaxRequest("GET", "ajax/request.php/bookings/" + id, editTravelModal, "userToken=" + userToken);
}

function editTravelModal(ajaxResponse) {
  var travel = JSON.parse(ajaxResponse);

  let status = "waiting";
  if(travel.validation_status == "ACCEPTED")
    status = "accepted";
  else if(travel.validation_status == "DENIED")
    status = "denied";

  let translations = {
    waiting: "En attente de validation",
    accepted: "Voyage accepté",
    denied: "Voyage refusé"
  };

  $("#travel-modal .modal-title").text(travel.title);
  $(".travel-modal-description").text(travel.description);
  $(".tmi-country").text(travel.country);
  $(".tmi-duration").text(travel.duration + " jours");
  $(".tmi-cost").text(travel.cost + " €");

  let dep = travel.departure_date.split("/").reverse();
  let ret = travel.return_date.split("/").reverse();

  $(".tmi-departure").val(dep[0] + "-" + dep[1] + "-" + dep[2]);
  $(".tmi-departure").attr("readonly", "true");
  $(".tmi-return").val(ret[0] + "-" + ret[1] + "-" + ret[2]);

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

  $("#modal-travel-status").html(
    `<span class="modal-travel-status travel-status travel-status-` + status + `">
      <img src="img/travel_status/` + status+ `.png" />
      <span>` + translations[status] + `</span>
    </span>`
  );

  $("#travel-modal").modal("show");
}
