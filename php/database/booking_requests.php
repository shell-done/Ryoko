<?php
require_once("php/classes/Booking.php");

function dbAddUserBooking($db, $booking) {
    $request = 'INSERT INTO booking( id_travel, user_email, departure_date, return_date, total_cost)
                VALUES (:id_travel, :email, :departure_date, :departure_date, :return_date, :total_cost)';

        $statement = $db->prepare($request);
        $statement->bindParam(':id_travel', $booking->getId(), PDO::PARAM_STR, 64);
        $statement->bindParam(':email', $booking->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(':departure_date', $booking->getDeparture(), PDO::PARAM_STR);
        $statement->bindParam(':return_date', $booking->getReturn(), PDO::PARAM_STR);
        $statement->bindParam(':total_cost', $booking->getTotalCost(), PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $exception) {
        error_log('Request error: '.$exception->getMessage());
        return false;
      }

      return true;
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
