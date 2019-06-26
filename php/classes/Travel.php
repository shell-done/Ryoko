<?php

class Travel {
  private $id_travel;
  private $title;
  private $description;
  private $duration;
  private $cost;
  private $img_directory;
  private $img_list;
  private $country;

  private $validation_status;
  private $departure_date;
  private $return_date;

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

  public function toArray() {
    return get_object_vars($this);
  }
}
