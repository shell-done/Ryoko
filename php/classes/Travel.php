<?php

class Travel {
  private $id_travel;
  private $title;
  private $description;
  private $duration;
  private $cost;
  private $img_directory;
  private $country;

  function __contruct($id="", $title="", $description="", $duration="", $cost="", $img_directory="", $country="") {
    $this->id_travel = $id;
    $this->title = $title;
    $this->description = $description;
    $this->duration = $duration;
    $this->cost = $cost;
    $this->img_directory = $img_directory;
    $this->country = $country;
  }

  public function getId() {return $this->id;}
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
}
