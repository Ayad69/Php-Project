<?php
class Loueur {
    private $id;
    private $nom;
    private $appels_ko;
    private $timeouts;
    private $dateAnalyse;

    
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getAppelsKo() {
        return $this->appels_ko;
    }

    public function getTimeouts() {
        return $this->timeouts;
    }

    public function getDateAnalyse() {
        return $this->dateAnalyse;
    }

    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setAppelsKo($appels_ko) {
        $this->appels_ko = $appels_ko;
        return $this;
    }

    public function setTimeouts($timeouts) {
        $this->timeouts = $timeouts;
        return $this;
    }

    public function setDateAnalyse($dateAnalyse) {
        $this->dateAnalyse = $dateAnalyse;
        return $this;
    }
}