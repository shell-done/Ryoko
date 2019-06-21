<?php

class Booking {
    private $id_travel;
    private $email;
    private $departure_date;
    private $return_date;
    private $total_cost;
    private $validation;

    public function __construct($user, $travel, $duree, $date_depart , $cout) {
        $this->email = $user->getEmail();
        $this->id_travel = $travel->getID();
        $this->departure_date = $date_depart;
        $this->return_date = date('d-m-Y',strtotime($date_depart.' + '.$duree.' days'));
        $this->total_cost = $cout;
    }

    public function getId() {return $this->id_travel;}
    public function setId($id) {$this->id_travel = $id_travel;}

    public function getEmail() {return $this->email;}
    public function setEmail($email) {$this->email = $email;}

    public function getDeparture() {return $this->departure;}
    public function setDeparture($departure_date) {$this->departure = $departure_date;}

    public function getReturn() {return $this->return;}
    public function setReturn($return_date) {$this->return = $return_date;}

    public function getTotalCost() {return $this->total_cost;}
    public function setCost($total_cost) {$this->total_cost = $total_cost;}

    public function getValidation(){return $this->validation;}
    public function setCost($validation) {$this->validation = $validation;}

}
