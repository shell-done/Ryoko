$(document).ready(function(){
  var date = new Date();
  var year = date.getFullYear();
  var month = (date.getMonth()+1).toString().padStart(2, '0');
  var day = date.getDate().toString().padStart(2, '0');

  $("#search-departure").val(year + "-" + month + "-" + day);

  $("#search-price").on("input", function () {
    var value = $(this).val();

    if(value == 5000)
      value = "> 5000";

    $("#search-price-value").text(value + " €");
  });
});
