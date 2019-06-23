<?php

class Booking {
    private $id_travel;
    private $email;
    private $token;
    private $departure_date;
    private $return_date;
    private $total_cost;
    private $validation;

    public function getId() {return $this->id_travel;}
    public function setId($id) {$this->id_travel = $id;}

    public function getEmail() {return $this->email;}
    public function setEmail($email) {$this->email = $email;}

    public function getToken() {return $this->token;}
    public function setToken($token) {$this->token = $token;}

    public function getDeparture() {return $this->departure;}
    public function setDeparture($departure_date) {$this->departure = $departure_date;}

    public function getReturn() {return $this->return;}
    public function setReturn($return_date) {$this->return = $return_date;}

    public function getCost() {return $this->total_cost;}
    public function setCost($total_cost) {$this->total_cost = $total_cost;}

    public function getValidation(){return $this->validation;}
    public function setValidation($validation) {$this->validation = $validation;}

    public function toArray() {
      return get_object_vars($this);
    }
}
