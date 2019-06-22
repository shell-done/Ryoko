function toInputDate(date) {
  let year = date.getFullYear();
  let month = (date.getMonth()+1).toString().padStart(2, '0');
  let day = date.getDate().toString().padStart(2, '0');

  return year + "-" + month + "-" + day;
}

$(document).ready(function(){
  $("#search-departure").val(toInputDate(new Date()));
  $("#search-departure").attr("min", toInputDate(new Date()));

  $("#search-price").on("input", function () {
    var value = $(this).val();

    if(value != 5000)
      value += " €";
    else
      value = "Tous";

    $("#search-price-value").text(value);
  });

  ajaxRequest("GET", "ajax/request.php/countries/", setCountries);

  $("#search-button").unbind("click").click(function(event) {
    event.preventDefault();

    let countryCode = $("#search-country").val();
    let durationDays = $("#search-duration").val();
    let departure = $("#search-departure").val();
    let price = $("#search-price").val();

    window.location.href = "research.php?country=" + countryCode + "&duration=" + durationDays + "&departure=" + departure + "&price=" + price;
  });
});

function setCountries(ajaxResponse) {
  var countries = JSON.parse(ajaxResponse);
  var text = "";

  text += "<option value='ALL'>Tous</option>";
  for(var i=0; i<countries.length; i++)
    text += "<option value='" + countries[i].iso_code + "'>" + countries[i].name + "</option>";

  $("#search-country").html(text);
}
