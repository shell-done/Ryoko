<?php
// \file booking.php
// Définit la classe Booking

//La classe Booking représente une réservation de voyage

class Booking {
    private $id_travel;//l'id du pays du voyage réservé
    private $title;//le libellé du voyage réservé
    private $email;//l'email de l'utilisateur qui a effectué la réservation
    private $token;//le token de l'utilisateur qui a effectué la réservation
    private $departure_date;//la date de départ pour le voyage réservé
    private $return_date;//la date de retour pour le voyage réservé
    private $total_cost;//le coût total de la réservation
    private $validation;//le statut de la réservation(si validée ou non par l'admin)
    private $country;//le pays du voyage réservé

    /************************************************************************/
    //Getters et Setters des attributs

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

    /************************************************************************/
    //Transforme l'objet en un tableau associatif
    //\return un tableau associatif attributs/valeurs
    public function toArray() {
      return get_object_vars($this);
    }
}
