$(document).ready(function(){
  var date = new Date();
  var year = date.getFullYear();
  var month = (date.getMonth()+1).toString().padStart(2, '0');
  var day = date.getDate().toString().padStart(2, '0');

  $("#search-departure").val(year + "-" + month + "-" + day);
  $("#search-departure").attr("min", year + "-" + month + "-" + day);

  $("#search-price").on("input", function () {
    var value = $(this).val();

    if(value == 5000)
      value = "> 5000";

    $("#search-price-value").text(value + " €");
  });

  $("#search-button").unbind('click').click(startResearch);

  ajaxRequest("GET", "ajax/request.php/countries/", setCountries);
  ajaxRequest("GET", "ajax/request.php/travels", travelsAvailable, "country=ALL" + "&duration=ALL" + "&departure=" + $("#search-departure").val() + "&price=5000");
});

function setCountries(ajaxResponse) {
  var countries = JSON.parse(ajaxResponse);
  var text = "";

  text += "<option name='ALL'>Tous</option>";
  for(var i=0; i<countries.length; i++)
    text += "<option name='" + countries[i].iso_code + "'>" + countries[i].name + "</option>";

  $("#search-country").html(text);
}

function startResearch(event) {
  event.preventDefault();

  var country = $("#search-country").val();
  var countryCode = $("#search-country").children("option:selected").attr("name");

  var duration = $("#search-duration").val();
  var durationDays = $("#search-duration").children("option:selected").attr("name");

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

    let text =  `<div class="travel row">
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
                    <span id="travel-` + travels[i].id_travel + `" class="travel-about" data-toggle="modal" data-target="#travel-modal">En savoir plus...</span>
                  </div>
                </div>`;

    $(".travels-container").append(text);
  }
}
