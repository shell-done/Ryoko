<?php
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["research", "user-navbar", "user-research", "travel", "footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>

    <?php require("parts/research-banner.html"); ?>

    <div class="container">
      <div class="results-box">
        <div class="results-header">
          <h2>Votre recherche</h2>
          <ul>
            <li>Pays : Grèce</li>
            <li>Durée : Toutes</li>
            <li>Départ : 20/96/2019</li>
            <li>Prix max. : 300 €</li>
          </ul>
        </div>

        <div class="container travels-container">
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
              <span class="travel-price">Prix : 500 €</span>
              <span class="travel-about" data-toggle="modal" data-target="#travel-modal">En savoir plus...</span>
            </div>
          </div>

          <div id="id-travel-2" class="travel row">
            <div class="col-md-4"><img src="img/default_thumb.png" /></div>
            <div class="col-md-8">
              <span class="travel-header">
                <h3>Week-end à Paris (France)</h3>
                <span class="travel-duration">Durée: 2 jours</span>
              </span>
              <p class="travel-description">
                Tempore quo primis auspiciis in mundanum fulgorem surgeret
                victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                foedere pacis aeternae .
              </p>
              <span class="travel-price">Prix : 500 €</span>
              <span class="travel-about" data-toggle="modal" data-target="#travel-modal">En savoir plus...</span>
            </div>
          </div>

          <div id="id-travel-3" class="travel row">
            <div class="col-md-4"><img src="img/default_thumb.png" /></div>
            <div class="col-md-8">
              <span class="travel-header">
                <h3>Istanbul (Turquie)</h3>
                <span class="travel-duration">Durée: 2 semaines</span>
              </span>
              <p class="travel-description">
                Tempore quo primis auspiciis in mundanum fulgorem surgeret
                victura dum erunt homines Roma, ut augeretur sublimibus incrementis,
                foedere pacis aeternae .
              </p>
              <span class="travel-price">Prix : 500 €</span>
              <span class="travel-about" data-toggle="modal" data-target="#travel-modal">En savoir plus...</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php require("parts/travel-popup.html") ?>

    <?php require("parts/footer.html"); ?>
  </body>

  <!-- Load scripts -->
  <script src="scripts/research.js" defer></script>
</html>
