<?php

require("../php/classes/User.php");
require("../php/database/database.php");
require("../php/database/user_requests.php");

function newUser ( $email, $name, $first_name, $phone, $city, $zip_code, $street, $birth_date, $country) {
    $db = dbConnect();
    $user = new User();
    $user->setEmail($email);
    $user->setPassword($password);
    $user->setName($name);
    $user->setFirstName($first_name);
    $user->setPhone($phone);
    $user->setCity($city);
    $user->setZipCode($zip_code);
    $user->setStreet($street);
    $user->setBirthDate($birth_date);
    $user->setCountry($country);
    $result = dbAddUser($db, $user);

    echo " Votre profil est ajouté !";
}

function newConnection($email, $password){
    $db = dbConnect();
    $result = dbStartUserSession($db, $email, $password);
}

?>
