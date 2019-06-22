<?php
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/User.php");

//Fonction pour récupérer un utilisateur en fonction de son email et de son mdp
function dbStartUserSession($db, $email, $password) {
    $result = false;

    try{
        $newToken = uniqid("", true);

        $request = 'UPDATE User SET token=:token WHERE email=:email AND password=:password';
        $statement = $db->prepare($request);
        $statement->bindParam(":token", $newToken);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", hash("sha256", $password));

        $statement->execute();

        return dbGetUser($db, $newToken);
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $result;
}

function dbGetUser($db, $userToken) {
  $result = false;

  try {
    $request = 'SELECT u.email AS email, u.name AS name, u.first_name AS first_name, u.phone AS phone, u.city AS city, u.zip_code AS zip_code, u.birth_date AS birth_date, u.street AS street, u.token AS token, c.name AS country
                FROM User u, Country c
                WHERE u.token=:token AND c.iso_code = u.country_code';

    $statement = $db->prepare($request);
    $statement->bindParam(":token", $userToken);
    $statement->execute();

    if($statement->rowCount() == 1)
      $result = $statement->fetchObject("User");
  }
  catch (PDOException $exception){
      error_log('Request error: ' . $exception->getMessage());
      return false;
  }

  return $result;
}
