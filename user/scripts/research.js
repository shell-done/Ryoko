var startResearchOnLoad = true; // Une recherche sera lancée dès que la page sera chargée

// Dès que la page est chargée
$(document).ready(function() {
  $("#search-button").unbind('click').click(startResearch);
  $("#book-button").unbind('click').click(function(event) { // En cas de click sur le bouton de réservation
    event.preventDefault();

    let travelID = $(this).attr("class").slice(7);
    let travelTitle = $("#travel-modal .modal-title").text();

    var data = "userToken=" + userToken +
               "&travelId=" + travelID +
               "&departureDate=" + $(".tmi-departure").val();

    // Envoie d'une requête Ajax POST pour demander la réservation
    ajaxRequest("POST", "ajax/request.php/bookings/", function(e) {showBookingMessage(travelTitle)}, data);
  });

  // Ajout des paramètres dans la barre de recherche
  initResearchBanner();
});

// Lance la recherche
// \param event L'evenement lancé par le click sur le bouton 'rechercher'
function startResearch(event) {
  event.preventDefault();

  // Récupération des paramètres de recherches
  let params = getResearchParameters();

  // Conversion de la date
  let date = new Date(params.departure);
  let year = date.getFullYear();
  let month = (date.getMonth()+1).toString().padStart(2, '0');
  let day = date.getDate().toString().padStart(2, '0');
  let departureFormated = day + "/" + month + "/" + year;

  // Affichage des informations de recherche
  let text = "<h2>Votre recherche</h2>" +
             "<ul>" +
                "<li>Pays : " + params.country +"</li>" +
                "<li>Durée : " + params.duration + "</li>" +
                "<li>Départ : " + departureFormated + "</li>" +
                "<li>Prix max. : " + (params.price == 5000 ? "Tous" : params.price + " €") + "</li>" +
              "</ul>";

  $(".results-header").html(text);

  // Lance la requête pour récupérer les voyages
  ajaxRequest("GET", "ajax/request.php/travels", travelsAvailable,
              'country=' + params.countryCode +
              '&duration=' + params.durationInDays +
              '&departure=' + params.departure +
              '&price=' + params.price);
}

// Affiche la liste des voyages
// \param ajaxResponse La réponse de la requête Ajax
function travelsAvailable(ajaxResponse) {
  var travels = JSON.parse(ajaxResponse);

  //Vide le container de résultat
  $(".travels-container").html("");

  // Si aucun voyage disponible, affichage d'un message d'erreur
  if(travels.length == 0) {
    let text = "<p class='no-travels'>Nous n'avons trouvé aucun voyage correspondant à vos critères :(</p>";
    $(".travels-container").append(text);
    return;
  }

  // Affichage d'un voyage
  for(let i=0; i<travels.length; i++) {
    let thumbnail = "img/default_thumb.png";
    if(travels[i].img_list.length != 0)
      thumbnail = travels[i].img_list[0];

    // Création et remplissage d'une div de voyage
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

    // Ajout du voyage dans le container
    $(".travels-container").append(text);
  }
}

// Demande les informations pour afficher les détails d'un voyage
// \param id Lid du voyage
function showTravelModal(id) {
  ajaxRequest("GET", "ajax/request.php/travels/" + id, editTravelModal, "userToken=" + userToken);
}

// Rempli le popup du détail d'un voyage et l'affiche
// \param ajaxResponse La réponse de la requête Ajax
function editTravelModal(ajaxResponse) {
  var travel = JSON.parse(ajaxResponse);

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

  $(".tmi-departure").attr("min", getInputDate(new Date()));

  let departure = $("#search-departure").val();
  $(".tmi-departure").val(departure);

  // Permet à la date d'arrivée d'être calculée en fonction de la date de départ
  $(".tmi-departure").change(function() {
    let departure = $(".tmi-departure").val();
    $(".print-departure").text(getFrenchDate(departure));

    let returnDate = new Date(departure);
    returnDate.setDate(returnDate.getDate() + parseInt(travel.duration));

    $(".tmi-return").val(getInputDate(returnDate));
    $(".print-return").text(getFrenchDate(getInputDate(returnDate)));
  });
  $(".tmi-departure").trigger("change");

  // Charge les bonnes images
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

  // Charge les images
  $(".travel-modal-thumbs").html(thumbsText);
  $(".travel-modal-thumbs img").unbind("click").click(function() {
    $("#travel-modal-img").attr("src", $(this).attr("src"));
  })

  // Affiche un bouton désactivé si le voyage a été réservé
  if(travel.validation_status === false) {
    $("#book-button").attr("class", "travel-" + travel.id_travel);
    $("#book-button").removeAttr("disabled");
  } else {
    $("#book-button").attr("class", "");
    $("#book-button").attr("disabled", "true");
  }

  // Affichage du popup de voyage
  $("#travel-modal").modal("show");
}

// Affichage d'un popup signifiant la réservation
// \param travelTitle Le titre du voyage
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
