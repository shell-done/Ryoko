<?php

class Country {
    private $iso_code;
    private $name;
    function __contruct($iso_code = "", $name = "") {
        $this->iso_code = $iso_code;
        $this->name = $name;
    }
    public function getIso_code() {return $this->iso_code;}
    public function setIso_code($iso_code) {$this->iso_code = $iso_code;}

    public function getName() {return $this->name;}
    public function setIso_code($name) {$this->name = $name;}
}
