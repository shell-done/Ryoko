<?php

class Booking {
    private $id_travel;
    private $title;
    private $email;
    private $token;
    private $departure_date;
    private $return_date;
    private $total_cost;
    private $validation;
    private $country;

    public function getId() {return $this->id_travel;}
    public function setId($id) {$this->id_travel = $id;}

    public function getTitle() {return $this->title;}
    public function setTitle($title) {$this->title = $title;}

    public function getEmail() {return $this->email;}
    public function setEmail($email) {$this->email = $email;}

    public function getToken() {return $this->token;}
    public function setToken($token) {$this->token = $token;}

    public function getDeparture() {return $this->departure_date;}
    public function setDeparture($departure_date) {$this->departure_date = $departure_date;}

    public function getReturn() {return $this->return_date;}
    public function setReturn($return_date) {$this->return_date = $return_date;}

    public function getCost() {return $this->total_cost;}
    public function setCost($total_cost) {$this->total_cost = $total_cost;}

    public function getValidation(){return $this->validation;}
    public function setValidation($validation) {$this->validation = $validation;}

    public function getCountry() {return $this->country;}
    public function setCountry($country) {$this->country = $country;}

    public function toArray() {
      return get_object_vars($this);
    }
}
