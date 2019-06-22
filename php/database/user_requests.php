<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/User.php");

//Fonction pour récupérer un utilisateur en fonction de son email et de son mdp
function dbGetUser($db, $email, $password = false) {
    $result = false;

    try{
        $request = 'SELECT u.email AS email u.name AS name, u.first_name AS first_name, u.phone AS phone, u.city AS city, u.zip_code AS zip_code, u.birth_date AS birth_date, c.name AS country
                    FROM User u, Country c
                    WHERE c.iso_code = country_code AND email=:email';

        if($password)
          $request .= " AND password=:password";

        $statement = $db->prepare($request);
        $statement->bindParam(":email", $email);

        if($password)
          $statement->bindParam(":password", hash("sha256", $password));
          
        $statement->execute();

        $statement = $db->prepare("SELECT * FROM User");
        $statement->execute();

        $result = $statement->fetchObject("User");
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $result;
}
