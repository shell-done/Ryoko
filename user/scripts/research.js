var startResearchOnLoad = true;

$(document).ready(function() {
  $("#search-button").unbind('click').click(startResearch);
  $("#book-button").unbind('click').click(function(event) {
    event.preventDefault();

    let travelID = $(this).attr("class").slice(7);
    let travelTitle = $("#travel-modal .modal-title").text();

    var data = "userToken=" + userToken +
               "&travelId=" + travelID +
               "&departureDate=" + $(".tmi-departure").val();

    ajaxRequest("POST", "ajax/request.php/booking/", function(e) {showBookingMessage(travelTitle)}, data);
  });

  initResearchBanner();
});

function startResearch(event) {
  event.preventDefault();

  let params = getResearchParameters();

  let date = new Date(params.departure);
  let year = date.getFullYear();
  let month = (date.getMonth()+1).toString().padStart(2, '0');
  let day = date.getDate().toString().padStart(2, '0');
  let departureFormated = day + "/" + month + "/" + year;

  let text = "<h2>Votre recherche</h2>" +
             "<ul>" +
                "<li>Pays : " + params.country +"</li>" +
                "<li>Durée : " + params.duration + "</li>" +
                "<li>Départ : " + departureFormated + "</li>" +
                "<li>Prix max. : " + (params.price == 5000 ? "Tous" : params.price + " €") + "</li>" +
              "</ul>";

  $(".results-header").html(text);

  ajaxRequest("GET", "ajax/request.php/travels", travelsAvailable,
              'country=' + params.countryCode +
              '&duration=' + params.durationInDays +
              '&departure=' + params.departure +
              '&price=' + params.price);
}

function travelsAvailable(ajaxResponse) {
  var travels = JSON.parse(ajaxResponse);

  $(".travels-container").html("");

  if(travels.length == 0) {
    let text = "<p class='no-travels'>Nous n'avons trouvé aucun voyage correspondant à vos critères :(</p>";
    $(".travels-container").append(text);
    return;
  }

  for(let i=0; i<travels.length; i++) {
    let thumbnail = "img/default_thumb.png";
    if(travels[i].img_list.length != 0)
      thumbnail = travels[i].img_list[0];

    let text =  `<div class="travel row" onclick="showTravelModal(` + travels[i].id_travel + `)">
                  <div class="col-md-4"><img src="` + thumbnail + `" /></div>
                  <div class="col-md-8">
                    <span class="travel-header">
                      <h3>` + travels[i].title + ` (` + travels[i].country + `)</h3>
                      <span class="travel-duration">Durée: ` + travels[i].duration + ` jours</span>
                    </span>
                    <p class="travel-description">
                      ` + travels[i].description + `
                    </p>
                    <span class="travel-price">Prix : ` + travels[i].cost + ` €</span>
                    <span class="travel-about">En savoir plus...</span>
                  </div>
                </div>`;

    $(".travels-container").append(text);
  }
}

function showTravelModal(id) {
  ajaxRequest("GET", "ajax/request.php/travels/" + id, editTravelModal, "userToken=" + userToken);
}

function editTravelModal(ajaxResponse) {
  var travel = JSON.parse(ajaxResponse);

  $("#travel-modal .modal-title").text(travel.title);
  $(".travel-modal-description").text(travel.description);
  $(".tmi-country").text(travel.country);
  $(".tmi-duration").text(travel.duration + " jours");
  $(".tmi-cost").text(travel.cost + " €");

  $(".tmi-departure").attr("min", getInputDate(new Date()));

  let departure = $("#search-departure").val();
  $(".tmi-departure").val(departure);

  $(".tmi-departure").change(function() {
    let departure = $(".tmi-departure").val();

    let returnDate = new Date(departure);
    returnDate.setDate(returnDate.getDate() + parseInt(travel.duration));

    $(".tmi-return").val(getInputDate(returnDate));
  });
  $(".tmi-departure").trigger("change");

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

function showBookingMessage(travelTitle) {
  showInfo(
    "Demande de réservation enregistrée",
    `<b>Votre demande réservation pour le voyage "` + travelTitle + `" a bien été prise en compte. </b>
     <br /><br />
     Celle-ci doit encore être validée par l'un de nos administrateur. <br />
     Pour connaitre la liste ainsi que l'état de vos demandes, rendez-vous sur votre page de profil accessible depuis la barre de navigation.
     <br /><br />

     Merci de votre confiance, <br />
     L'équipe Ryokō.`);
}
