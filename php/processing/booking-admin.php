<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require("$serverRoot/php/classes/Booking.php");
require("$serverRoot/php/database/database.php");
require("$serverRoot/php/database/booking_requests.php");

function DisplayBookings() {
    $db = dbConnect();
    $bookings = dbGetAllBooking($db);

    foreach($bookings as $booking) {
      $validColumn = null;

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
