<?php
//Fonction pour afficher tout les voyages disponibles
function dbShowUser($db){
    $results = array();

    try{
        $request = 'SELECT email, name, firstname, phone, city, zip_code, birth_date, c.name AS country FROM User, Country c WHERE c.iso_code = country_code';
        $statement = $db->prepare($request);
        $statement->execute();

        $obj = $statement->fetchObject("User");
        while($obj) {
          array_push($results, $obj);
          $obj = $statement->fetchObject("User");
        }

        $result = $statement->fetchAll(PDO::FETCH_CLASS, "User");
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $results;
}