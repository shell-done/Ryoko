<?php
// \file booking-admin.php
// Contient toutes les fonctions nécessaires pour générer la page booking de l'administrateur

  // Inclus les fichiers nécessaires
  $serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
  require("$serverRoot/php/classes/Booking.php");
  require("$serverRoot/php/database/database.php");
  require("$serverRoot/php/database/booking_requests.php");

  // Génère les lignes du tableau affichant les réservations
  function DisplayBookings() {
    $db = dbConnect();
    $bookings = dbGetAllBooking($db); // Récupération de toutes les réservations

    foreach($bookings as $booking) {
      $validColumn = null;

      // Pour chaque réservation, on affiche 'Accepté' ou 'Refusé' si la décision a déjà été prise
      // On affiche deux boutons 'Accepter' et 'Refuser' si aucune décision n'a été prise
      if($booking->getValidation() == "WAITING") {
        $validColumn = "<td class='validation-cell'>
          <button type='button' onclick='accept(`" . $booking->getId() ."`, `" . $booking->getEmail() . "`)'>Accepter</button>
          <button type='button' onclick='deny(`" . $booking->getId() ."`, `" . $booking->getEmail() . "`)'>Refuser</button>
        </td>";
      } else if($booking->getValidation() == "DENIED") {
        $validColumn = "<td><span class='booking-status'> Refusé </span></td>";
      } else if($booking->getValidation() == "ACCEPTED") {
        $validColumn = "<td><span class='booking-status'> Accepté </span></td>";
      }

      // On génère la ligne correspondant à une réservation
      echo "<tr class='booking-row status-" . strtolower($booking->getValidation()) . "'>
              <td>" . $booking->getEmail(). "</td>
              <td>" . $booking->getCountry() . "</td>
              <td><div class='table-title'>" . $booking->getTitle() . "</div></td>
              <td>" . $booking->getDeparture() . "</td>
              <td>" . $booking->getReturn() . "</td>
              <td>" . $booking->getCost() . "€ </td>
              $validColumn
            </tr>";
    }
  }

?>
