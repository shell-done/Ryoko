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
        $statement->bindValue(':id_travel', $booking->getId(), PDO::PARAM_STR);
        $statement->bindValue(':token', $booking->getToken(), PDO::PARAM_STR);
        $statement->bindValue(':departure_date', $booking->getDeparture(), PDO::PARAM_STR);

        return $statement->execute();
    } catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return false;
}

function dbGetValidationStatus($db, $userToken, $travelID) {
  try {
    $request = 'SELECT validation_status
                FROM Booking, User
                WHERE user_email=email AND token=:token AND id_travel=:id_travel';

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

function dbGetUserBookedTravels($db, $userToken) {
  $results = false;

  try{
      $request = 'SELECT t.id_travel AS id_travel, title, description, duration, total_cost AS cost, img_directory, DATE_FORMAT(departure_date, "%e/%m/%Y") AS departure_date, DATE_FORMAT(return_date, "%e/%m/%Y") as return_date, validation_status, c.name AS country
                  FROM Travel t, Country c, Booking b, User u
                  WHERE u.email = b.user_email AND token=:token AND t.id_travel = b.id_travel AND c.iso_code = t.country_code
                  ORDER BY b.updated DESC';

      $statement = $db->prepare($request);
      $statement->bindParam(':token', $userToken, PDO::PARAM_STR, 32);

      $statement->execute();
      $results = $statement->fetchAll(PDO::FETCH_CLASS, "Travel");

      $root = $_SERVER["DOCUMENT_ROOT"] . "/../";
      for($i=0; $i<count($results); $i++) {
        $path = $root . $results[$i]->getImgDirectory();
        $fileList = array();
        foreach(glob($path . '*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE) as $file){
            array_push($fileList, $results[$i]->getImgDirectory() . basename($file));
        }

        $results[$i]->setImgPathList($fileList);
      }
  }
  catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
  }

  return $results;
}

function dbGetUserBookedTravel($db, $userToken, $idTravel) {
  $result = false;

  try{
      $request = 'SELECT t.id_travel AS id_travel, title, description, duration, total_cost AS cost, img_directory, DATE_FORMAT(departure_date, "%e/%m/%Y") AS departure_date, DATE_FORMAT(return_date, "%e/%m/%Y") as return_date, validation_status, c.name AS country
                  FROM Travel t, Country c, Booking b, User u
                  WHERE u.email = b.user_email AND token=:token AND t.id_travel = :idTravel AND t.id_travel = b.id_travel AND c.iso_code = t.country_code';

      $statement = $db->prepare($request);
      $statement->bindParam(':token', $userToken, PDO::PARAM_STR, 32);
      $statement->bindParam(':idTravel', $idTravel);

      $statement->execute();
      $result = $statement->fetchObject("Travel");

      $root = $_SERVER["DOCUMENT_ROOT"] . "/../";
      $path = $root . $result->getImgDirectory();
      $fileList = array();
      foreach(glob($path . '*.{jpg,JPG,jpeg,JPEG,png,PNG}', GLOB_BRACE) as $file) {
        array_push($fileList, $result->getImgDirectory() . basename($file));
      }

      $result->setImgPathList($fileList);
  }
  catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
  }

  return $result;
}

function dbDeleteBooking($db, $booking){
    try{
        $request = 'DELETE FROM Booking
                    WHERE user_email = :user_email AND id_travel = :id_travel';

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
    $results = false;

    try{
        $request = 'SELECT b.id_travel AS id_travel, user_email AS email, title, country_code AS country, DATE_FORMAT(departure_date, "%d/%m/%Y") AS departure_date,
                      DATE_FORMAT(return_date, "%d/%m/%Y") AS return_date, total_cost, validation_status AS validation
                    FROM Booking b, Travel t
                    WHERE b.id_travel = t.id_travel
                    ORDER BY b.updated DESC';

        $statement = $db->prepare($request);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_CLASS, "Booking");
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return $results;
}

function dbValidationBooking($db, $booking) {
    try{
        $request = 'UPDATE Booking
                    SET validation_status = :validation_status
                    WHERE user_email = :user_email AND id_travel = :id_travel';

        $statement = $db->prepare($request);

        $statement->bindValue(':user_email', $booking->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':id_travel', $booking->getId(), PDO::PARAM_INT);
        $statement->bindValue(':validation_status', $booking->getValidation(), PDO::PARAM_STR);

        return $statement->execute();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }

    return false;
}
