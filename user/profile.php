<?php
  require_once("../php/processing/log_user.php");
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["user-navbar", "user-banner", "profile", "travel", "footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>

    <?php require("parts/default-banner.html"); ?>

    <div class="container">
      <div class="account-box">
        <h2>Mon compte</h2>
        <div class="row">
          <div class="col-md-3 align-self-center">
            <img src="img/user-icon.png" class="account-img"/>
          </div>
          <div class="user-info-list col-md-9 align-self-center">
            <div class="row">
              <span class="col-md-6"><h4>Nom :</h4> <span class="user-info ui-name">THOMAS</span></span>
              <span class="col-md-6"><h4>Prénom :</h4> <span class="user-info ui-first-name">Alexandre</span></span>
            </div>
            <div class="row">
              <span class="col-md-12"><h4>Date de naissance :</h4> <span class="user-info ui-birthdate">20/09/1999</span></span>
            </div>
            <div class="row">
              <span class="col-md-12"><h4>Adresse :</h4> <span class="user-info ui-street">20 Rue Cuirassé de Bretagne</span></span>
            </div>
            <div class="row">
              <span class="col-md-6"><h4>Ville :</h4> <span class="user-info ui-city">Brest</span></span>
              <span class="col-md-6"><h4>Code postal :</h4> <span class="user-info ui-zipcode">29200</span></span>
            </div>
            <div class="row">
              <span class="col-md-12"><h4>Téléphone :</h4> <span class="user-info ui-phone">07.87.83.45.12</span></span>
            </div>
            <div class="row">
              <span class="col-md-12"><h4>Adresse mail :</h4> <span class="user-info ui-email">user.name@webmail.com</span></span>
            </div>

            <div class="row">
              <button type="button" class="user-disconnect" disabled>Se déconnecter</button>
            </div>
          </div>
        </div>
      </div>

      <div class="results-box">
        <h2>Mes voyages Ryokō</h2>

        <div id="bookings-container" class="container">
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
                <span></span>
                <span class="travel-status travel-status-denied">
                  <img src="img/travel_status/denied.png" />
                  <span>Refusé</span>
                </span>
              </span>
            </div>
          </div>
        </div>

      </div>

      <?php require("parts/travel-popup.html"); ?>
      <?php require("parts/info-popup.html"); ?>
      <?php require("parts/footer.html"); ?>
    </div>
  </body>

  <?php require("../php/parts/user_session_token.php"); ?>
  <script src="scripts/ajax.js" defer></script>
  <script src="scripts/utilities.js" defer></script>
  <script src="scripts/profile.js" defer></script>
</html>
