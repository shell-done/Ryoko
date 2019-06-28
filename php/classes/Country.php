<?php
// \file country.php
// Définit la classe Country

//La classe Country représente un pays
class Country {
    private $iso_code;//le code iso d'un pays
    private $name;//le nom du pays

    /************************************************************************/
    //Constructeur de la classe Country
    //\param iso_code Le code ISO du pays
    //\param name Le nom du pays
    function __contruct($iso_code = "", $name = "") {
        $this->iso_code = $iso_code;
        $this->name = $name;
    }

    /************************************************************************/
    //Getters et Setters des attributs
    public function getIso_code() {return $this->iso_code;}
    public function setIso_code($iso_code) {$this->iso_code = $iso_code;}

    public function getName() {return $this->name;}
    public function setName($name) {$this->name = $name;}


    /************************************************************************/
    //Transforme l'objet en un tableau associatif
    //\return un tableau associatif attributs/valeurs
    public function toArray() {
      return get_object_vars($this);
    }
}
