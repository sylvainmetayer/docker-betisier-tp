<?php
class Mot {
	private $mot_id;
	private $mot_interdit;

  public function __construct($valeurs = array()) {
    if (! empty ( $valeurs )) {
      $this->affecte ( $valeurs );
    }
  }

  public function affecte($donnees) {
    foreach ( $donnees as $attribut => $valeurs ) {
      switch ($attribut) {
        case 'mot_id' :
          $this->setMotId ( $valeurs );
          break;
        case 'mot_interdit' :
          $this->setMotInterdit ( $valeurs );
          break;
      }
    }
  }

  public function setMotId($mot_id) {
    $this->mot_id = $mot_id;
  }

  public function setMotInterdit($mot_interdit) {
		if (empty($mot_interdit)) {
			throw new ExceptionPerso("Le mot interdit ne peut etre vide !", ExceptionPerso::ERR_PEBCAK);
		}
    $this->mot_interdit = $mot_interdit;
  }

  public function getMotId() {
    return $this->mot_id;
  }

  public function getMotInterdit() {
    return $this->mot_interdit;
  }
}
