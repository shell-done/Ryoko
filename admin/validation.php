<?php
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["index", "admin-navbar", "admin-travel-add", "navbar", "footer"]);?>

  <body>
    <?php require("parts/navbar_admin.html"); ?>
    <?php require("parts/navbar.html"); ?>
    <div class="container">
      <div class="results-box">
        <h2>Valider les voyages</h2>

        <div class="container">
          <div id="id-travel-1" class="travel row">
            <div class="col-md-4"><img src="img/default_thumb.png" /></div>
            <div class="col-md-8">
              <span class="travel-header">
                <h3>Cancún (Mexique)</h3>
                <span class="travel-duration">Durée: 5 jours</span>
              </span>
              <p class="travel-description">
                Tempore quo primis auspiciis in mundanum fulgorem surgeret
                victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                foedere pacis aeternae .
              </p>
              <div class="travel-date">
                <span class="travel-departure">Départ:<br />18/06/19</span>
                <span class="travel-arrival">Arrivée:<br />20/06/19</span>
                <span class="travel-price">Prix:<br />500 €</span>
              </div>

              <span class="travel-status-box">
                <span class="travel-status travel-status-accepted">
                  <img src="img/travel_status/accepted.png" />
                  <span>Accepté</span>
                </span>
                <span class="travel-status travel-status-denied">
                  <img src="img/travel_status/denied.png" />
                  <span>Refusé</span>
                </span>
              </span>
            </div>
          </div>
        </div>

        <div class="container">
          <div id="id-travel-1" class="travel row">
            <div class="col-md-4"><img src="img/default_thumb.png" /></div>
            <div class="col-md-8">
              <span class="travel-header">
                <h3>Cancún (Mexique)</h3>
                <span class="travel-duration">Durée: 5 jours</span>
              </span>
              <p class="travel-description">
                Tempore quo primis auspiciis in mundanum fulgorem surgeret
                victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                foedere pacis aeternae .
              </p>
              <div class="travel-date">
                <span class="travel-departure">Départ:<br />18/06/19</span>
                <span class="travel-arrival">Arrivée:<br />20/06/19</span>
                <span class="travel-price">Prix:<br />500 €</span>
              </div>

              <span class="travel-status-box">
                <span class="travel-status travel-status-accepted">
                  <img src="img/travel_status/accepted.png" />
                  <span>Accepté</span>
                </span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require("parts/footer.html"); ?>
  </body>
</html>
