<?php
  require_once("../php/processing/log_user.php");
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["user-navbar", "user-banner", "about", "footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>

    <?php require("parts/default-banner.html"); ?>

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

    <?php require("parts/footer.html"); ?>
  </body>

  <?php require("../php/parts/user_session_token.php"); ?>
  <script src="scripts/utilities.js" defer></script>
</html>
