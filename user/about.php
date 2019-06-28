<?php
  // \file about.php
  // Page affichée par le navigateur contenant les informations à propos du site

  // Inclus les fichiers nécessaires
  require_once("../php/processing/log_user.php");
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["user-navbar", "user-banner", "about", "footer"]); //Génère le head et inclus les styles associés à la page ?>

  <body>
    <?php require("parts/navbar.html"); //Affiche la barre de navigation ?>

    <?php require("parts/default-banner.html"); // Affiche le fond de la barre de navigation ?>

    <div class="about container">
      <h2>A propos de Ryokō</h2>
      <p>
        Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum
        erunt homines Roma, ut augeretur sublimibus incrementis, foedere pacis
        aeternae Virtus convenit atque Fortuna plerumque dissidentes, quarum si
        altera defuisset, ad perfectam non venerat summitatem.
      </p>
      <p>
        Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum
        erunt homines Roma, ut augeretur sublimibus incrementis, foedere pacis
        aeternae Virtus convenit atque Fortuna plerumque dissidentes, quarum si
        altera defuisset, ad perfectam non venerat summitatem.
      </p>
      <p>
        Tempore quo primis auspiciis in mundanum fulgorem surgeret victura dum
        erunt homines Roma, ut augeretur sublimibus incrementis, foedere pacis
        aeternae Virtus convenit atque Fortuna plerumque dissidentes, quarum si
        altera defuisset, ad perfectam non venerat summitatem.
      </p>
    </div>

    <?php require("parts/info-popup.html"); // Récupère le popup d'information ?>
    <?php require("parts/footer.html"); // Affiche le footer ?>
  </body>

  <?php require("../php/parts/user_session_token.php"); // Ajoute le token de session sur la page?>
  <script src="scripts/ajax.js" defer></script>
  <script src="scripts/utilities.js" defer></script>
</html>
