function toInputDate(date) {
  let year = date.getFullYear();
  let month = (date.getMonth()+1).toString().padStart(2, '0');
  let day = date.getDate().toString().padStart(2, '0');

  return year + "-" + month + "-" + day;
}

$(document).ready(function(){
  var date = new Date();

  $("#search-departure").val(toInputDate(date));
  $("#search-departure").attr("min", toInputDate(date));

  $("#search-price").on("input", function () {
    var value = $(this).val();

    if(value != 5000)
      value += " €";
    else
      value = "Tous";

    $("#search-price-value").text(value);
  });

  $("#search-button").unbind('click').click(startResearch);

  ajaxRequest("GET", "ajax/request.php/countries/", setCountries);
});

function setResearchParam() {
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

  $("#search-button").trigger("click");
}

function setCountries(ajaxResponse) {
  var countries = JSON.parse(ajaxResponse);
  var text = "";

  text += "<option value='ALL'>Tous</option>";
  for(var i=0; i<countries.length; i++)
    text += "<option value='" + countries[i].iso_code + "'>" + countries[i].name + "</option>";

  $("#search-country").html(text);

  setResearchParam();
}

function startResearch(event) {
  event.preventDefault();

  var country = $("#search-country option:selected").text();
  var countryCode = $("#search-country").val();

  var duration = $("#search-duration option:selected").text();
  var durationDays = $("#search-duration").val();

  var departure = $("#search-departure").val();
  var price = $("#search-price").val();

  var date = new Date(departure);
  var year = date.getFullYear();
  var month = (date.getMonth()+1).toString().padStart(2, '0');
  var day = date.getDate().toString().padStart(2, '0');
  var departureFormated = day + "/" + month + "/" + year;

  var text = "<h2>Votre recherche</h2>" +
             "<ul>" +
                "<li>Pays : " + country +"</li>" +
                "<li>Durée : " + duration + "</li>" +
                "<li>Départ : " + departureFormated + "</li>" +
                "<li>Prix max. : " + price + " €</li>" +
              "</ul>";

  $(".results-header").html(text);

  ajaxRequest("GET", "ajax/request.php/travels", travelsAvailable,
              "country=" + countryCode + "&duration=" + durationDays + "&departure=" + departure + "&price=" + price);
}

function travelsAvailable(ajaxResponse) {
  var travels = JSON.parse(ajaxResponse);

  console.log(travels);
  $(".travels-container").html("");

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
  ajaxRequest("GET", "ajax/request.php/travels/" + id, editTravelModal);
}

function editTravelModal(ajaxResponse) {
  var travel = JSON.parse(ajaxResponse);

  console.log(travel);

  $(".modal-title").text(travel.title);
  $(".travel-modal-description").text(travel.description);
  $(".tmi-country").text(travel.country);
  $(".tmi-duration").text(travel.duration + " jours");
  $(".tmi-cost").text(travel.cost + " €");

  $(".tmi-departure").attr("min", toInputDate(new Date()));

  let departure = $("#search-departure").val();
  $(".tmi-departure").val(departure);

  $(".tmi-departure").change(function() {
    let departure = $(".tmi-departure").val();

    let returnDate = new Date(departure);
    returnDate.setDate(returnDate.getDate() + parseInt(travel.duration));

    $(".tmi-return").val(toInputDate(returnDate));
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

  $("#travel-modal").modal("show");
}
