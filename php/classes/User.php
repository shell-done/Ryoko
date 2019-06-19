<?php

class User {
  private $email;
  private $password;
  private $name;
  private $first_name;
  private $phone;
  private $city;
  private $zip_code;
  private $birth_date;
  private $country;

  function __construct($email, $pwd, $name, $first_name, $phone, $city, $zip, $birth_date, $country) {
    $this->email = $email;
    $this->passowrd = $pwd;
    $this->name = $name;
    $this->first_name = $first_name;
    $this->phone = $phone;
    $this->city = $city;
    $this->zip_code = $zip;
    $this->birth_date = $birth_date;
    $this->country = $country;
  }

  public function getEmail() {return $this->email;}
  public function setEmail($email) {$this->email = $email;}

  public function getPassword() {return $this->password;}
  public function setPassword($password){$this->password = $password;}

  public function getName() {return $this->name;}
  public function setName($name) {$this->name = $name;}

  public function getFirstName() {return $this->first_name;}
  public function setFirstName($first_name){$this->first_name = $first_name;}

  public function getPhone(){return $this->phone;}
  public function setPhone($phone){$this->phone = $phone;}

  public function getCity(){return $this->city;}
  public function setCity($city){$this->city = $city;}

  public function getZipCode(){return $this->zip_code;}
  public function setZipCode($zip_code){$this->zip_code = $zip_code;}

  public function getBirthDate(){return $this->birth_date;}

  public function setBirthDate($birth_date){$this->birth_date = $birth_date;}

  public function getCountry(){return $this->country;}
  public function setCountry($country){$this->country = $country;}
}
