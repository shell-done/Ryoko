var startResearchOnLoad = false;

$(document).ready(function(){
  ajaxRequest("GET", "ajax/request.php/user/" + userID, showUser);

  initResearchBanner();

  $("#search-button").unbind("click").click(function(event) {
    event.preventDefault();

    let params = getResearchParameters();

    window.location.href = 'research.php?' +
      'country=' + params.countryCode +
      '&duration=' + params.durationInDays +
      '&departure=' + params.departure +
      '&price=' + params.price;
  });
});
