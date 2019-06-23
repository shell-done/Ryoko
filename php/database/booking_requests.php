<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/Booking.php");

function dbAddUserBooking($db, $booking) {
    try {
        $request = 'INSERT INTO Booking(id_travel, user_email, departure_date, return_date, total_cost)
                    SELECT :id_travel AS id_travel, email AS user_email, :departure_date AS departure_date, DATE_ADD(:departure_date, INTERVAL duration DAY) AS return_date, cost AS total_cost
                    FROM User, Travel
                    WHERE token=:token AND id_travel=:id_travel;';

        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $booking->getId(), PDO::PARAM_STR, 64);
        $statement->bindParam(':token', $booking->getToken(), PDO::PARAM_STR);
        $statement->bindParam(':departure_date', $booking->getDeparture(), PDO::PARAM_STR);

        return $statement->execute();
    } catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return false;
}

function dbGetValidationStatus($db, $userToken, $travelID) {
  try {
    $request = 'SELECT validation_status FROM Booking, User WHERE user_email=email AND token=:token AND id_travel=:id_travel';

    $statement = $db->prepare($request);
    $statement->bindParam(":token", $userToken);
    $statement->bindParam(":id_travel", $travelID);

    $statement->execute();

    if($statement->rowCount() == 1)
      return $statement->fetch(PDO::FETCH_ASSOC)["validation_status"];
    else
      return false;
  } catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      return false;
  }

  return false;
}

function dbGetUserBooking($db, $booking) {
    try{
        $request = 'SELECT * FROM booking WHERE user_email = :user_email';
        $statement = $db->prepare($request);
        $statement->bindParam(':user_email', $booking->getEmail(), PDO::PARAM_STR, 128);
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}

function dbDeleteBooking($db, $booking){
    try{
        $request = 'DELETE FROM Booking WHERE user_email = :user_email AND id_travel = :id_travel';
        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $booking->getId(), PDO::PARAM_INT);
        $statement->bindParam(':user_email', $booking->getEmail(), PDO::PARAM_STR, 128);
        $statement->execute();
    } catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return true;
}

function dbGetAllBooking($db) {
    try{
        $request = 'SELECT * FROM booking';
        $statement = $db->prepare($request);
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}




function dbValidationBooking($db, $booking, $travel, $validation_status) {
    try{
        $request = 'UPDATE booking SET validation_status = :validation_status  WHERE user_email = :user_email AND id_travel = :id_travel ';
        $statement = $db->prepare($request);
        $statement->bindParam(':user_email', $booking->getEmail(), PDO::PARAM_STR, 128);
        $statement->bindParam(':validation_status', $validation_status, PDO::PARAM_STR, 128);
        $statement->bindParam(':id_travel', $travel->getId(), PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}
