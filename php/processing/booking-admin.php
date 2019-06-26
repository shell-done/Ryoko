<?php

require("../php/classes/Booking.php");
require("../php/database/database.php");
require("../php/database/booking_requests.php");
session_start();

function AvailableBookings() {
    $db = dbConnect();
    $bookings = dbGetAllBooking($db);
    
    foreach($bookings as $booking) {
        echo "<tr>
                <td class = 'User'> 
                    ".$booking->user_email." 
                </td>
                <td class = 'name'> 
                    Id :".$booking->getId()." Titre :".$booking->title."
                </td>
                <td class = 'departure'>
                    ".$booking->getDeparture()."
                </td>
                <td class = 'return'> 
                    ".$booking->getReturn()."
                </td>
                <td class = 'total-cost'> 
                    ".$booking->getCost()."
                </td>
                <td class = 'validation'> 
                    <div>
                        <input type='radio' id='accepter' name='drone' value='accepter'>
                        <label for='accepter'>accepter</label>
                    </div><div>
                        <input type='radio' id='refuser' name='drone' value='refuser'>
                        <label for='refuser'>refuser</label>
                    </div>
                </td>
            <tr>"
        ;
    }
  }

?>
