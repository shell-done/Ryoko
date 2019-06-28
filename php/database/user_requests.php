<?php
// \file user_requests.php
// Définit les méthodes de requêtes en BDD liées aux utilisateurs

//Inclus les fichiers nécessaires
$serverRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
require_once("$serverRoot/php/classes/User.php");

/************************************************************************************************************/

// Ajoute un utilisateur dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param user L'objet 'user' à insérer en base
// \return false si une erreur s'est produite, true sinon.
function dbAddUser($db, $user) {
  try{
      $request = 'INSERT INTO User(email, password, name, first_name, phone, city, zip_code, street, birth_date, country_code)
                  VALUES(:email, :password, :name, :first_name, :phone, :city, :zip_code, :street, :birth_date, :country_code)';

      $statement = $db->prepare($request);
      $statement->bindValue(":email", $user->getEmail());
      $statement->bindValue(":password", hash("sha256", $user->getPassword()));
      $statement->bindValue(":name", $user->getName());
      $statement->bindValue(":first_name", $user->getFirstName());
      $statement->bindValue(":phone", $user->getPhone());
      $statement->bindValue(":city", $user->getCity());
      $statement->bindValue(":zip_code", $user->getZipCode());
      $statement->bindValue(":street", $user->getStreet());
      $statement->bindValue(":birth_date", $user->getBirthDate());
      $statement->bindValue(":country_code", $user->getCountry());

      return $statement->execute();
  }
  catch (PDOException $exception){
      error_log('Request error: ' . $exception->getMessage());
      return false;
  }
}

/************************************************************************************************************/

// Récupère un utilisateur et génère un token (en fonction de son email et de son mdp un utilisateur) dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param email l'e-mail de l'utilisateur
// \param password  le mot de passe de l'utilisateur
// \return un objet 'User' ou false en cas d'erreur
function dbStartUserSession($db, $email, $password) {
    $result = false;

    try{
        $newToken = uniqid("", true);

        $request = 'UPDATE User SET token=:token
                    WHERE email=:email AND password=:password';
        $statement = $db->prepare($request);
        $statement->bindValue(":token", $newToken);
        $statement->bindValue(":email", $email);
        $statement->bindValue(":password", hash("sha256", $password));

        $statement->execute();

        return dbGetUser($db, $newToken);
    }
    catch (PDOException $exception){
        error_log('Request error: ' . $exception->getMessage());
        return false;
    }

    return $result;
}

/************************************************************************************************************/

// Récupère un utilisateur (en fonction de son token) dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param userToken le token de l'utilisateur
// \return un objet 'User' ou false en cas d'erreur
function dbGetUser($db, $userToken) {
  $result = false;

  try {
    $request = 'SELECT email, u.name AS name, first_name, phone, city, zip_code, DATE_FORMAT(birth_date, "%d/%m/%Y") AS birth_date, street, token, c.name AS country
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

/************************************************************************************************************/

// Vérifie si le token existe dans la base de donnée
// \param db Un objet PDO connecté à la base
// \param token le token de l'utilisateur
// \return true si le token existe ou false sinon
function dbCheckToken($db, $token) {
  try {
    $request = 'SELECT email
                FROM User
                WHERE token=:token';

    $statement = $db->prepare($request);
    $statement->bindParam(":token", $token);
    $statement->execute();

    if($statement->rowCount() == 1)
      return true;
  }
  catch (PDOException $exception){
      error_log('Request error: ' . $exception->getMessage());
      return false;
  }

  return false;
}
