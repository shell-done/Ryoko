<?php
  require_once("../php/parts/head.php");
  require_once("../php/processing/utilities.php");
  require_once("../php/processing/booking-admin.php");
?>

<html>
  <?php generateHead(["index", "navbar", "header", "bookings","footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>
    <?php require("parts/header.html"); ?>

    <div class="container">
        <div class="results-box">
            <h2>Réservations</h2>

            <div class="bookings-header">
              <div class="btn-group sort-bookings" role="group">
                <button type="button" class="btn" value="all">Tout</button>
                <button type="button" class="btn" value="waiting">En attente</button>
                <button type="button" class="btn" value="accepted">Acceptés</button>
                <button type="button" class="btn" value="denied">Refusés</button>
              </div>
            </div>

            <div class="container">
              <table class="list">
                <tr>
                  <th>Email</th>
                  <th>Pays</th>
                  <th>Titre</th>
                  <th>Date de départ</th>
                  <th>Date de retour</th>
                  <th>Coût total</th>
                  <th>Validation</th>
                </tr>
                <?php DisplayBookings(); ?>
              </table>
            </div>
        </div>
    </div>

    <form id="set-status" style="display: none;" method="post" action="forms/confirmTravel.php">
      <input type="hidden" name="userEmail" />
      <input type="hidden" name="travelId" />
      <input type="hidden" name="status" />
      <input type="hidden" name="sort" />
    </form>

    <?php showInfErr($_GET["info"], $_GET["error"]); ?>
    <?php require("parts/footer.html"); ?>
  </body>

  <script src="scripts/bookings.js" defer></script>
</html>
