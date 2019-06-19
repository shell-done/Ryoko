<?php

function dbGetUserBooking($db, $email, $id_voyage, $date_depart, $date_retour, $cout_total, $statut_validation) {
    try{
        $request = 'SELECT * FROM booking WHERE user_email = :user_email';
        $statement = $db->prepare($request);
        $statement->bindParam(':user_email', $email, PDO::PARAM_STR, 128);
        $statement->execute();
        $result = $statement->fetchAll();
    }
    catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
    return $result;
}
