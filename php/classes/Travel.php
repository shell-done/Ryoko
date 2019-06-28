<?php

//La classe Travel représente un voyage

class Travel {
  private $id_travel;//l'id du voyage
  private $title;//le libellé du voyage
  private $description;//la description du voyage
  private $duration;//la durée du voyage
  private $cost;//le coût du voyage
  private $img_directory;//le dossier des images du voyage
  private $img_list;//la chemin des images du voyages
  private $country;//la pays du voyage
  private $validation_status;//le statut de validation du voyage
  private $departure_date;//la date de départ du voyage
  private $return_date;//la date de retour du voyage

  /************************************************************************/
  //Getters et Setters des attributs

  public function getId() {return $this->id_travel;}
  public function setId($id) {$this->id_travel = $id;}

  public function getTitle() {return $this->title;}
  public function setTitle($title) {$this->title = $title;}

  public function getDescription() {return $this->description;}
  public function setDescription($description) {$this->description = $description;}

  public function getDuration() {return $this->duration;}
  public function setDuration($duration) {$this->duration = $duration;}

  public function getCost() {return $this->cost;}
  public function setCost($cost) {$this->cost = $cost;}

  public function getImgDirectory() {return $this->img_directory;}
  public function setImgDirectory($img_directory) {$this->img_directory = $img_directory;}

  public function getCountry() {return $this->country;}
  public function setCountry($country) {$this->country = $country;}

  public function getImgPathList() {return $this->img_list;}
  public function setImgPathList($img_list) {$this->img_list = $img_list;}

  public function getValidationStatus() {return $this->validation_status;}
  public function setValidationStatus($status) {$this->validation_status = $status;}

  public function getDeparture() {return $this->departure;}
  public function setDeparture($departure_date) {$this->departure = $departure_date;}

  public function getReturn() {return $this->return;}
  public function setReturn($return_date) {$this->return = $return_date;}

  /************************************************************************/
  //Transforme l'objet en un tableau associatif
  //\return un tableau associatif attributs/valeurs
  
  public function toArray() {
    return get_object_vars($this);
  }
}
